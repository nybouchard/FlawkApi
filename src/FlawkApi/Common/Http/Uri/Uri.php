<?php
/**
 * @package    FlawkApi
 * @subpackage Uri Compliant class
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common\Http\Uri;

use InvalidArgumentException;
 
/**
 * Standards-compliant Uri class
 */
class Uri implements UriInterface {
  
  // @var string
  private $scheme = 'http';
  
  // @var string
  private $host;
  
  // @var int
  private $port = 80;
  
  // @var string
  private $path = '/';
  
  // @var string
  private $query = '';
  
  // @var string
  private $fragment = '';
  
  /**
   * @param str $uri
   */
  public function __construct($uri = NULL){
    if($uri !== NULL){
      $this->parseUri($uri);
    }
  }
  
  /**
   * @param string $uri
   * @throws \InvalidArgumentException
   */
  public function parseUri($uri) {
    if (!$uriParts = @parse_url($uri)) {
      throw new InvalidArgumentException('Invalid URI: '.$uri);
    }
        
    if (!isset($uriParts["scheme"])) {
      throw new InvalidArgumentException('Invalid URI: http|https scheme required');
    }
    
    $this->scheme = $uriParts["scheme"];
    $this->host = $uriParts["host"];
    
    if (isset($uriParts["port"])) {
      $this->port = $uriParts["port"];
    }
    
    $this->path = $uriParts["path"];
    
    if (isset($uriParts["query"])) {
      $this->query = $uriParts["query"];
    }
    
    if (isset($uriParts["fragment"])) {
      $this->fragment = $uriParts["fragment"];
    }
    
  }
  
  /**
   * @return string
   */
  public function getScheme(){
    return $this->scheme;
  }
  
  /**
   * @return string
   */
  public function getHost(){
    return $this->host;
  }
  
  /**
   * @return int
   */
  public function getPort(){
    return $this->port;
  }
  
  /**
   * @return string
   */
  public function getPath(){
    return $this->path;
  }
  
  /**
   * @return string
   */
  public function getQuery(){
    return $this->query;
  }
  
  /**
   * @return string
   */
  public function getFragment(){
    return $this->fragment;
  }
  
  public function getAbsoluteUri(){
    $uri = $this->scheme . '://' . $this->host . $this->path;
    
    if (!empty($this->query)) {
      $uri .= "?{$this->query}";
    }

    if (!empty($this->fragment)) {
      $uri .= "#{$this->fragment}";
    }
    
    return $uri;
  }

}