<?php
/**
 * PSR-0 Standard Autoloader
 *
 * @package    FlawkApi
 * @subpackage AutoLoader
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common;

/**
 * PSR-0 Compliant Autoloader
 */

class AutoLoader {

  // @var string the namespace prefix
  protected $namespace = '';
  
  // @var string the path prefix
  protected $path = '';
  
  /**
   * __contruct method to initiate the instance of the AutoLoader
   *
   * @param string $namespace
   * @param string $path
   */
  public function __construct($namespace, $path){
    $this->namespace = ltrim($namespace, '\\');
    $this->path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
  }
  
  /**
   * load method to load library files
   *
   * @param string $class
   * @return true if successfull
   */
  public function load($class){
    $class = ltrim($class, '\\');
        
    if(strpos($class, $this->namespace) === 0){
    
      $nsparts   = explode('\\', $class);
      $class     = array_pop($nsparts);
      $nsparts[] = '';
      $path      = $this->path . implode(DIRECTORY_SEPARATOR, $nsparts);      
      $path      .= str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
            
      if (is_readable($path)) {
        require $path;
        return true;
      }
    }
    return false;
  }
  
  /**
   * register method, registers the autoloader
   *
   * @return boolean registration status
   */
  public function register(){
    return spl_autoload_register(array($this, 'load'));
  }
  
  /**
   * unregister method, unregisters the autoloader
   *
   * @return boolean unregistration status
   */
  public function unregister(){
    return spl_autoload_unregister(array($this, 'load'));
  }

}