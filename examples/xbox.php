<?php
/**
 * Example of the xbox service.
 *
 * @package    Flawk Api
 * @subpackage Xbox Example
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

use FlawkApi\Services\Xbox;

// include bootstrap
require_once (__DIR__.'/bootstrap.php');

// initiate Playstation with gamer ID string and httpClient
$FlawkApi = new Xbox($gamerIds['xbox']['id'], $httpClientProvider());

// getProfile returns an array of available profile information
$profile = $FlawkApi->getProfile();

echo $profile["gamerId"] . " has " . $profile["reputation"] . " reputation points.";
