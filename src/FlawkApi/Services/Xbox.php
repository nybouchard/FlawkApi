<?php
/**
 * @package    FlawkApi
 * @subpackage Xbox Live Api
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Services;

use FlawkApi\Common\Http\Uri\Uri;
use FlawkApi\Common\Exception\Exception;
use FlawkApi\Services\Exception\ServiceException;

/**
 * Xbox Live Api
 *
 * This Xbox Live API is NOT using Microsoft's official Developer API and is instead using XboxLeader's public API.
 * Which means any use [of] automated process or service (such as a bot, a spider, periodic caching of information stored by
 * Microsoft, or metasearching) to access or use the Service, or to copy or scrape data from the Service" is prohibited by the 
 * Xbox Live Terms of Service. Failure to adhere to the Xbox Live TOS can be punishable by having your Xbox Live account suspended
 * or banned from the Xbox Live service. The authors are not responsible for the use of this.
 */
class Xbox extends Service {
  
  /**
   * @param string $gamerId
   * @throw FlawkApi\Services\Exception\Exception; throw's if gamerId invalid
   */
  public function setGamerId($gamerId){
    if(!empty($gamerId)) {
	  $this->gamerId = $gamerId;
	     
	} else {
	  throw new ServiceException('The gamerId is invalid.');
    }  
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\Uri
   */
  public function getProfileUri(){
    return new Uri("http://www.xboxleaders.com/api/profile/".$this->gamerId.".xml");
  }
  
  /**
   * @return array; returns curl options for /FlawkApi/Common/Parser/FlawkParser;
   */
  public function getProfileOpts(){
    return array(
      CURLOPT_HTTPHEADER     => array('Content-Type: text/xml; charset=UTF-8'),
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_CONNECTTIMEOUT => 3,
      CURLOPT_RETURNTRANSFER => true
    );
  }
  
  /**
   * @param array $response;
   * @return array $nodes; list of available profile information
   */
  public function parseProfile(array $response){
    $parseAttributes = array (
	    'tier'             => array('.//Tier', 'string'),
	    'isValid'          => array('.//IsValid', 'int'),
	    'isBanned'         => array('.//IsCheater', 'int'),
	    'isOnline'         => array('.//IsOnline',  'int'),
	    'onlineStatus'     => array('.//OnlineSatus', 'string'),
	    'xblLaunchTeam'    => array('.//XBLLaunchTeam', 'int'),
	    'nxeLaunchTeam'    => array('.//NXELaunchTeam', 'int'),
	    'kinectLaunchTeam' => array('.//KinectLaunchTeam', 'int'),
	    'avatarTile'       => array('.//AvatarTile', 'string'),
	    'avatarSmall'      => array('.//AvatarSmall', 'string'),
	    'avatarLarge'      => array('.//AvatarLarge', 'string'),
	    'avatarBody'       => array('.//AvatarBody', 'string'),
	    'gamerId'          => array('.//Gamertag', 'string'),
	    'gamerScore'       => array('.//GamerScore', 'int'),
	    'reputation'       => array('.//Reputation', 'int'),
	    'name'             => array('.//Name', 'string'),
	    'motto'            => array('.//Motto', 'string'),
	    'location'         => array('.//Location', 'string'),
	    'bio'              => array('.//Bio', 'string')
    );
    
    
    return $this->flawkParser->parseXML($response, $parseAttributes);
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\Uri
   */
  public function getGamesUri(){
    return new Uri("http://www.xboxleaders.com/api/games/".$this->gamerId.".xml");
  }
  
  /**
   * @return array; returns curl options for /FlawkApi/Common/Parser/FlawkParser;
   */
  public function getGamesOpts() {
    return array(
      CURLOPT_HTTPHEADER     => array('Content-Type: text/xml; charset=UTF-8'),
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_CONNECTTIMEOUT => 3,
      CURLOPT_RETURNTRANSFER => true
    );
  }
  
  /**
   * @param array $response;
   * @return array $nodes; list of available profile information
   */
  public function parseGames(array $response) {
    $parseAttributes = array(
      'gameCount'   => array('.//GameCount', 'int'),
    );
    
    $gameCount = $this->flawkParser->parseXML($response, $parseAttributes);
    $data    = array();
    
    // irerate through the and normalize the played games
    for ($i = 1; $i < $gameCount['gameCount']; $i++) {
      $parseAttributes = array(
        'gameId'               => array('.//PlayedGames['.$i.']/Id', 'string'),
        'gameTitle'            => array('.//PlayedGames['.$i.']/Title', 'decode-string'),
        'gameUrl'              => array('.//PlayedGames['.$i.']/Url', 'string'),
        'apiAchievementsUrl'   => array('.//PlayedGames['.$i.']/ApiAchievementsUrl', 'string'),
        'boxArt'               => array('.//PlayedGames['.$i.']/BoxArt', 'string'),
        'boxArtLarge'          => array('.//PlayedGames['.$i.']/LargeBoxArt', 'string'),
        'earnedGamerScore'     => array('.//PlayedGames['.$i.']/EarnedGamerScore', 'int'),
        'possibleGamerScore'   => array('.//PlayedGames['.$i.']/PossibleGamerScore', 'int'),
        'earnedAchievements'   => array('.//PlayedGames['.$i.']/EarnedAchievements', 'int'),
        'possibleAchievements' => array('.//PlayedGames['.$i.']/PossibleAchievements', 'int'),
        'percentageCompleted'  => array('.//PlayedGames['.$i.']/PercentageCompleted', 'int'),
        'lastPlayed'           => array('.//PlayedGames['.$i.']/LastPlayed', 'string'),
      );
      
      $data[$i] = $this->flawkParser->parseXML($response, $parseAttributes);
    }
    
    return $data;
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\Uri
   */
  public function getAchievementsUri() {
    return new Uri("http://www.xboxleaders.com/api/games/".$this->gamerId.".xml");
  }
  
  /**
   * @return array; returns curl options for /FlawkApi/Common/Parser/FlawkParser;
   */
  public function getAchievementsOpts() {
    return array(
      CURLOPT_HTTPHEADER     => array('Content-Type: text/xml; charset=UTF-8'),
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_CONNECTTIMEOUT => 3,
      CURLOPT_RETURNTRANSFER => true
    );
  }
  
  /**
   * @param array $response;
   * @return array $nodes; list of available profile information
   */
  public function parseAchievements(array $response) {
    $parseAttributes = array(	                                   
      'gamerId'                   => array('//Gamertag', 'string'),
      'avatarUrl'                 => array('//Gamerpic', 'string'),
      'gameCount'                 => array('//GameCount', 'int'),
      'totalEarnedGamerScore'     => array('//TotalEarnedGamerScore', 'int'),
      'totalPossibleGamerScore'   => array('//TotalPossibleGamerScore', 'int'),
      'totalEarnedAchievements'   => array('//TotalEarnedAchievements', 'int'),
      'totalPossibleAchievements' => array('//TotalPossibleAchievements', 'int'),
      'totalPercentCompleted'     => array('//TotalPercentCompleted', 'int')
    );
    
    return $this->flawkParser->parseXML($response, $parseAttributes);
  }

}