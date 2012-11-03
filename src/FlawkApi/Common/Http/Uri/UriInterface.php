<?php
/**
 * @package    FlawkApi
 * @subpackage Uri Compliant Interface
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common\Http\Uri;

use InvalidArgumentException;

interface UriInterface {

  /**
   * @param string $uri
   */
  public function __construct($uri = NULL);
  
  /**
   * @param str $uri
   * @throws \InvalidArgumentException
   */
  public function parseUri($uri);
  
  /**
   * @return string
   */
  public function getScheme();
  
  /**
   * @return string
   */
  public function getHost();
  
  /**
   * @return int
   */
  public function getPort();
  
  /**
   * @return string
   */
  public function getPath();
  
  /**
   * @return string
   */
  public function getQuery();
  
  /**
   * @return string
   */
  public function getFragment();

}