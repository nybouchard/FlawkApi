<?php
/**
 * Bootstrap the library
 *
 * @package    Flawk Api
 * @subpackage Bootstrap
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
namespace FlawkApi;

require_once (__DIR__.'/Common/AutoLoader.php');

$autoloader = new \FlawkApi\Common\AutoLoader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

$httpClientProvider = function(){
  return new \FlawkApi\Common\Http\Client\FlawkClient();
};