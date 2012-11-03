<?php
/**
 * @package    FlawkApi
 * @subpackage Steam Public Api
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Services;

use FlawkApi\Common\Http\Uri\Uri;
use FlawkApi\Common\Exception\Exception;
use FlawkApi\Services\Exception\ServiceException;

class Steam extends Service {

  /**
   * var string $gamerId; requested gamerId;
   */
  public function setGamerId($gamerId) {
    if (empty($gamerId)) {
      throw new ServiceException('The gamerId is invalid.');
	  }
	  
	  $this->gamerId = $gamerId;
  }
  
  /**
   * @return string; returns the base url according to the gamer id type (numeric or custom)
   */
  public function getBaseUri(){
    if (is_numeric($this->gamerId)) {
      return "http://steamcommunity.com/profiles/{$this->gamerId}";
    }
    
    return "http://steamcommunity.com/id/{$this->gamerId}";
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\Uri
   */
  public function getProfileUri() {
    return new Uri($this->getBaseUri()."/?xml=1");
  }
  
  /**
   * @return array; returns curl options for /FlawkApi/Common/Parser/FlawkParser;
   */
  public function getProfileOpts() {
    return array(
      CURLOPT_HTTPHEADER     => array('Content-Type: text/xml; charset=UTF-8'),
      CURLOPT_TIMEOUT        => 10,
      CURLOPT_CONNECTTIMEOUT => 3,
      CURLOPT_RETURNTRANSFER => true
    );
  }
  
  /**
   * @param array $response; http client response array
   * @return array $data; 
   */
  public function parseProfile(array $response) {
    $parseAttributes = array(
      'gamerId64'       => array('.//steamID64', 'string'),
      'gamerId'         => array('.//steamID', 'string'),
      'stateMessage'    => array('.//stateMessage', 'string'),
      'onlineState'     => array('.//onlineState', 'string'),
      'privacyState'    => array('.//privacyState', 'string'),
      'visibilityState' => array('.//visibilityState', 'int'),
      'avatarIcon'      => array('.//avatarIcon', 'string'),
      'avatarMedium'    => array('.//avatarMedium', 'string'),
      'avatarFull'      => array('.//avatarFull', 'string'),
      'isBanned'        => array('.//varBanned', 'bool')
    );
    
    return $this->flawkParser->parseXML($response, $parseAttributes);
  }
  
  /**
   * @return FlawkApi\Common\Http\Uri\Uri
   */
  public function getGamesUri() {
    return new Uri($this->getBaseUri()."/games?xml=1");
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
   * @param array $response; http client response array
   * @return array $data; 
   */
  public function parseGames(array $response) {
    $parseAttributes = array(
      'games' => array('.//games', 'array')
    );  
   
    $games     = $this->flawkParser->parseXML($response, $parseAttributes);
    $data      = array();
    $gameCount = 0;
    
    // iterate through the games array and find the number of games.
    foreach ($games['games'] as $game) {
      foreach ($game as $key => $value) {
        $gameCount++;
      }
    }
    
    // iterate and normalize the games array into a new array called $data;
    for ($i = 1; $i < $gameCount; $i++) {
      $parseAttributes = array(
        'appID'           => array('.//games/game['.$i.']/appID', 'int'),
        'name'            => array('.//games/game['.$i.']/name', 'string'),
        'logo'            => array('.//games/game['.$i.']/logo', 'string'),
        'storeLink'       => array('.//games/game['.$i.']/storeLink', 'string'),
        'hoursLast2Weeks' => array('.//games/game['.$i.']/hoursLast2Weeks', 'float'),
        'hoursOnRecord'   => array('.//games/game['.$i.']/hoursOnRecord', 'float'),
        'statsLink'       => array('.//games/game['.$i.']/statsLink', 'string'),
        'globalStatsLink' => array('.//games/game['.$i.']/globalStatsLink', 'string'),
      );
      
      $data[$i] = $this->flawkParser->parseXML($response, $parseAttributes);
    }
        
    return $data;
  }

}
