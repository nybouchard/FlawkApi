<?php
/**
 * Service class provides a base class for the other implementations. 
 *
 * @package    FlawkApi
 * @subpackage Service Class
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Services;

use FlawkApi\Common\Http\Client\ClientInterface;
use FlawkApi\Common\Http\Uri\UriInterface;
use FlawkApi\Common\Parser\FlawkParser;
use FlawkApi\Services\Exception\ServiceException;

class Service implements ServiceInterface {
  
  // @var string Gamer Network Id (Gamertag, Psn, Steam Id)
  protected $gamerId;
  
  // @var FlawkApi\Common\Http\Client\ClientInterface $httpClient;
  protected $httpClient;
  
  // @var FlawkApi\Common\Parser\FlawkParser $flawkParser
  protected $flawkParser;
  
  
  // Additional variables for Playstation Service
  // @var string $jid; Gamers server url
  protected $jid;
  
  // @var string $region; Gamers server region
  protected $region;
  
  //@var string $firmware; Playstation firmware version
  protected $firmware = null;
  
  
  // Additional variables for Steam Service
  // @var int $gamerId64; Steam 64bit ID
  protected $gamerId64;
  
  /**
   * @param string $gamerId; the gamer id
   * @param FlawkApi\Common\Http\Client\ClientInterface $httpClient
   */
  public function __construct($gamerId, ClientInterface $httpClient){
    $this->httpClient = $httpClient;
    $this->flawkParser = new FlawkParser();
    $this->setGamerId($gamerId);
  }
  
  /**
   * @param /FlawkApi/Common/Http/Uri/Uri $curlUri
   * @return /FlawkApi/Common/Http/Client/ $response
   */
  public function retrieveResponse(UriInterface $curlUri, array $curlOpts) {
    return $this->httpClient->retrieveResponse($curlUri, $curlOpts);
  }
  
  /**
   * Service needs getProfileUri(), getProfileOpts() 
   *
   * @return array $response;
   */
  public function getProfile(){
    $curlUri  = $this->getProfileUri();
    $curlOpts = $this->getProfileOpts();    
    
    $response = $this->retrieveResponse($curlUri, $curlOpts);
    return $this->parseProfile($response);
  }
  
  /**
   * Service needs getGamesUri(), getGamesOpts() 
   *
   * @return array $response;
   */
  public function getGames(){
    $curlUri  = $this->getGamesUri();
    $curlOpts = $this->getGamesOpts();
    
    $response = $this->retrieveResponse($curlUri, $curlOpts);
    return $this->parseGames($response);
  }
  
  /**
   * Service needs getAchievementsUri(), getAchievementsOpts() 
   *
   * @return array $response;
   */
  public function getAchievements() {
    $curlUri  = $this->getAchievementsUri();
    $curlOpts = $this->getAchievementsOpts();
    
    $response = $this->retrieveResponse($curlUri, $curlOpts);
    return $this->parseAchievements($response);
  }

}