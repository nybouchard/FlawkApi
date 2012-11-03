<?php
/**
 * @package FlawkApi
 * @subpackage ServiceInterface
 * @author Yannick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 Yannick Bouchard
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace FlawkApi\Services;

use FlawkApi\Common\Http\Client\ClientInterface;
use FlawkApi\Common\Http\Uri\UriInterface;
use FlawkApi\Common\Parser\FlawkParser;
use FlawkApi\Services\Exception\ServiceException;

interface ServiceInterface {

  /**
   * @param string $gamerId; the gamer id
   * @param FlawkApi\Common\Http\Client\ClientInterface $httpClient
   */
  public function __construct($gamerId, ClientInterface $httpClient);
  
  /**
   * @param /FlawkApi/Common/Http/Uri/Uri $curlUri
   * @return $response /FlawkApi/Common/Http/Client/
   */
  public function retrieveResponse(UriInterface $curlUri, array $curlOpts);
  
  /**
   * Service needs getProfileUri(), getProfileOpts() 
   *
   * @return array $response;
   */
  public function getProfile();
  
  /**
   * Service needs getGamesUri(), getGamesOpts() 
   *
   * @return array $response;
   */
  public function getGames();
  
  /**
   * Service needs getAchievementsUri(), getAchievementsOpts() 
   *
   * @return array $response;
   */
  public function getAchievements();

}