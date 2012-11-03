<?php
/**
 * Example of the playstation service.
 *
 * @package    Flawk Api
 * @subpackage Bootstrap
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

use FlawkApi\Services\Playstation;

// include bootstrap
require_once (__DIR__.'/bootstrap.php');

// initiate Playstation with gamer ID string and httpClient
$FlawkApi = new Playstation($gamerIds['playstation']['id'], $httpClientProvider());

// returning information like getProfile(), getGames(), getAchievements()
$profile      = $FlawkApi->getProfile();
$achievements = $FlawkApi->getAchievements();

echo $profile["gamerId"] . " is at level " . $achievements["level"] . ".";