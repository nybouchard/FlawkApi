<?php
/**
 * Example of the steam service.
 *
 * @package    Flawk Api
 * @subpackage Steam Example
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

use FlawkApi\Services\Steam;

// include bootstrap
require_once (__DIR__.'/bootstrap.php');

// initiate Steam with example gamerid and httpClient
$FlawkApi = new Steam($gamerIds['steam']['id'], $httpClientProvider());

// getProfile returns an array of availble profile information
$profile = $FlawkApi->getProfile();

echo $profile["gamerId"] . " is currently " . $profile["onlineState"] . ".";
