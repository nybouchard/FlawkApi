<?php
/**
 * @package    FlawkApi
 * @subpackage Http Client Interface
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common\Http\Client;

use FlawkApi\Common\Http\Uri\UriInterface;
use FlawkApi\Common\Http\Client\Exception\ClientException;

interface ClientInterface {

  /**
   * @throw FlawkApi\Common\Http\Client\Exception\ClientException;
   */
  public function __construct();
  
  /**
   * @param FlawkApi\Common\Uri\UriInterface $uri;
   * @param array $curlOpts; array of curl_* options
   * @return string $responseBody; Http client response
   */
  public function retrieveResponse(UriInterface $uri, array $curlOpts);

}