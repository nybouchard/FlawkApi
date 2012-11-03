<?php
/**
 * @package    FlawkApi
 * @subpackage Playstation Network Api
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Services;

use FlawkApi\Common\Http\Uri\Uri;
use FlawkApi\Common\Exception\Exception;
use FlawkApi\Services\Exception\ServiceException;

class Playstation extends Service {

  // Login Passwords 
  const BasicLogin  = "c7y-basic01:A9QTbosh0W0D^{7467l-n_>2Y%JG^v>o"; 
  const TrophyLogin = "c7y-trophy01:jhlWmT0|:0!nC:b:#x/uihx'Y74b5Ycx";
    
  /**
   * Returns curl options to mock playstation headers in order to get a response from their servers
   * @param array $curlOpts;
   * @returns array $playstationOpts;
   */
  private function mockPlaystationHeaders(array $curlOpts){
    $playstationOpts = array(
      CURLOPT_USERAGENT      => "PS3Application libhttp/3.5.5-000 (CellOS)",
      CURLOPT_HTTPHEADER     => array('Content-Type: text/xml; charset=UTF-8'),
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_CONNECTTIMEOUT => 3,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST           => 1,
      CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST
    );
    
    foreach ($curlOpts as $opt => $value) {
      $playstationOpts[$opt] = $value;
    }
    
    return $playstationOpts;
  }
  
  /**
   * Returns the latest playstation firmware needed
   * @returns string $firmware;
   */
  public function setFirmwareVersion(){
    $curlUrl = new Uri("http://fus01.ps3.update.playstation.net/update/ps3/list/us/ps3-updatelist.txt");
    $curlOpts = array(
      CURLOPT_USERAGENT      => "Mozilla/5.0 (X11; Linux i686; rv:5.0) Gecko/20100101 Firefox/5.0",
      CURLOPT_TIMEOUT        => 10, 
      CURLOPT_CONNECTTIMEOUT => 3, 
      CURLOPT_RETURNTRANSFER => true
    );

    // use the FlawkClient to retrieve response
    $response = $this->httpClient->retrieveResponse($curlUrl, $curlOpts);
    
    preg_match_all("%;SystemSoftwareVersion=(.*?)00;%", $response["body"], $firmware); 
    $this->firmware = $firmware['1']['0'];
  }
  
  /**
   * Sets the gamerid and jid to determine which server the user resides
   * @param string gamerId
   * @throws ServiceException
   */
  public function setGamerId($gamerId){
    if(empty($gamerId)){
      throw new ServiceException('The gamerId is invalid.');
	}
	
	$this->gamerId = $gamerId;
	$this->setFirmwareVersion();
	$this->setJid($gamerId);
  }
  
  /**
   * @param string $gamerId; Gamer's Id
   */
  public function setJid($gamerId) {
    $serverUrls = array(
      'us' => 'http://searchjid.usa.np.community.playstation.net/basic_view/func/search_jid', 
      'gb' => 'http://searchjid.eu.np.community.playstation.net/basic_view/func/search_jid', 
      'jp' => 'http://searchjid.jpn.np.community.playstation.net/basic_view/func/search_jid'
    );
    
    foreach ($serverUrls as $region => $url) {
      $curlUrl = new Uri($url);
      $curlOpts = array(
        CURLOPT_POSTFIELDS => "<searchjid platform='ps3' sv='{$this->firmware}'><online-id>{$gamerId}</online-id></searchjid>",
        CURLOPT_USERPWD    => self::BasicLogin
      );
      
      $curlOpts = $this->mockPlaystationHeaders($curlOpts);     
      
      $response = $this->httpClient->retrieveResponse($curlUrl, $curlOpts);
            
      if ($response["code"] == '200'){
        preg_match("%<jid>(.*?)</jid>%", $response["body"], $match);
        
        $this->jid = $match[0];
        $this->region = $region;
                        
        break;
      }
      
    }
    
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\UriInterface;
   */
  public function getProfileUri() {
    return new Uri("http://getprof.{$this->region}.np.community.playstation.net/basic_view/func/get_profile");
  }
  
  /**
   * @return array $curlOpts; curl_* options array
   */
  public function getProfileOpts() {
  
    $curlOpts = array(
      CURLOPT_POSTFIELDS => "<profile platform='ps3' sv='{$this->firmware}'><jid>{$this->jid}</jid></profile>",
      CURLOPT_USERPWD    => self::BasicLogin
    );
    
    $curlOpts = $this->mockPlaystationHeaders($curlOpts);
    return $curlOpts;
  }
  
  /**
   * @param array $response; http client response array
   * @return array $data; 
   */
  public function parseProfile(array $response) {
    $parseAttributes = array(
      'gamerId'      => array('//onlinename', 'string'),
      'country'      => array('//country', 'string'),
      'aboutMe'      => array('//aboutme', 'string'),
      'avatarLarge'  => array('//avatarurl', 'string'),
      'profileColor' => array('//ucbgp', 'string'),
      'plusIcon'     => array('//plusicon', 'string')
    );
    
    return $this->flawkParser->parseXML($response, $parseAttributes);
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\UriInterface;
   */
  protected function getGamesUri() {
    return new Uri("http://trophy.ww.np.community.playstation.net/trophy/func/get_title_list");
  }
  
  /**
   * @return array; returns curl options for /FlawkApi/Common/Parser/FlawkParser;
   */
  protected function getGamesOpts() {
    $curlOpts = array(
      CURLOPT_POSTFIELDS => "<nptrophy platform='ps3' sv='{$this->firmware}'><jid>{$this->jid}</jid><start>1</start><max>1</max></nptrophy>",
      CURLOPT_USERPWD    => self::TrophyLogin
    );
    
    $curlOpts = $this->mockPlaystationHeaders($curlOpts);
    return $curlOpts;
  }
  
  /**
   * @param array $response; http client response array
   * @return array $data; 
   */
  public function parseGames(array $response) {  
    
    $data            = array();
    $parseAttributes = array('gameCount' => array('.//title', 'int'));
    $totalGames      = $this->flawkParser->parseXML($response, $parseAttributes);
        
    for ($i = 1; $i < $totalGames['gameCount']; $i++) {
      $tempOpts = array(
        CURLOPT_POSTFIELDS => "<nptrophy platform='ps3' sv='{$this->firmware}'><jid>{$this->jid}</jid><start>{$i}</start><max>64</max></nptrophy>",
        CURLOPT_USERPWD    => self::TrophyLogin
      );
      $tempOpts = $this->mockPlaystationHeaders($tempOpts);
      $tempResponse = $this->httpClient->retrieveResponse($this->getGamesUri(), $tempOpts);
      
      $parseAttributes = array(
        'npcommid'    => array('.//info/@npcommid', 'string'),
        'platform'    => array('.//info/@pf', 'string'),
        'platinum'    => array('.//info/types/@platinum', 'int'),
        'gold'        => array('.//info/types/@gold', 'int'),
        'silver'      => array('.//info/types/@silver', 'int'),
        'bronze'      => array('.//info/types/@bronze', 'int'),
        'lastUpdated' => array('.//info/last-updated', 'string')
      );

      $data[$i] = $this->flawkParser->parseXML($tempResponse, $parseAttributes);
    }
         
    return $data;
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\UriInterface;
   */
  public function getAchievementsUri() {
    return new Uri("http://trophy.ww.np.community.playstation.net/trophy/func/get_user_info");
  }
  
  /**
   * @return array $curlOpts; curl_* options array
   */
  public function getAchievementsOpts() {
    $curlOpts = array(
      CURLOPT_POSTFIELDS => "<nptrophy platform='ps3' sv='{$this->firmware}'><jid>{$this->jid}</jid></nptrophy>",
      CURLOPT_USERPWD    => self::TrophyLogin
    );
    
    $curlOpts = $this->mockPlaystationHeaders($curlOpts);
    return $curlOpts;
  }
  
  /**
   * @param array $response; http client response array
   * @return array $data; 
   */
  public function parseAchievements(array $response) {
    $parseAttributes = array(
      'points'   => array('/*/point', 'int'),
      'level'    => array('/*/level', 'int'),
      'base'     => array('/*/level/@base', 'int'),
      'next'     => array('/*/level/@next', 'int'),
      'progress' => array('/*/level/@progress', 'string'),
      'platinum' => array('/*/types/@platinum', 'int'),
      'gold'     => array('/*/types/@gold', 'int'),
      'silver'   => array('/*/types/@silver', 'int'),
      'bronze'   => array('/*/types/@bronze', 'int')
    );
    
    return $this->flawkParser->parseXML($response, $parseAttributes);
  }
  
}
