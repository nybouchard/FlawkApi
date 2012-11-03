<?php
/**
 * Bootstrap for example purposes.
 *
 * PHP version 5.3 (needed it to support 5.3)
 *
 * @package    Flawk Api
 * @subpackage Bootstrap
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

require_once (__DIR__.'/../src/FlawkApi/bootstrap.php');

// error reporting on
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include some example gamer ids
require_once (__DIR__.'/init.php');