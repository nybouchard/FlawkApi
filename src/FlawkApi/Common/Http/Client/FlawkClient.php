<?php
/**
 * @package    FlawkApi
 * @subpackage Flawk Http Client
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 Nick Bouchard
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace FlawkApi\Common\Http\Client;

use FlawkApi\Common\Http\Uri\UriInterface;
use FlawkApi\Common\Http\Client\Exception\ClientException;


class FlawkClient implements ClientInterface {

  /**
   * @throw Butler\Common\Http\Client\Exception\ClientException;
   */
  public function __construct(){
    if (!function_exists('curl_init')) {
      throw new ClientException('cURL is not enabled');
    }
  }
  
  /**
   * @param FlawkApi\Common\Uri\UriInterface $uri;
   * @param array $curlOpts; array of curl_* options
   * @return string $responseBody; Http client response
   * @throw FlawkApi\Common\Client\Exception\ClientException;
   */
  public function retrieveResponse(UriInterface $uri, array $curlOpts){
    $ch = curl_init();
    
    $curlOpts[CURLOPT_URL] = $uri->getAbsoluteUri();
    
    curl_setopt_array($ch, $curlOpts);
    
    $responseBody = curl_exec($ch);
    $httpCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
    
    // check for cURL errors and throws a ClientException
    if(curl_errno($ch)) {
      throw new ClientException('cURL error: ' . curl_error($ch));
    }

    curl_close($ch);
    
    return array("code" => $httpCode, "body" => $responseBody);
  }

}