### Playstation Service

#### Overview
-----------

This service implementation uses the same creditials found in the [PlayStation Network Java Library](http://code.google.com/p/playstation-network/).  

##### Usage
*(For more in-dept examples check out the /examples directory.)*
-----------

```php
<?php
// namespace for the Playstation Service
use FlawkApi\Services\Playstation;

// include FlawkApi bootstrap
require_once (__DIR__.'/bootstrap.php');

// FlawkClient() is the http client that comes with the FlawkApi package
$httpClientProvider = function(){
  return new \FlawkApi\Common\Http\Client\FlawkClient();
};

$FlawkApi = new Playstation("carlosvaldosta", $httpClientProvider);

```

Using the $FlawkApi object

```php
// using the getProfile() function
$profile = $FlawkApi->getProfile();

var_dump($profile["gamerId"]);

outputs:
["gamerId"]=>
  string(14) "carlosvaldosta"

```

##### Function List
*($FlawkApi = new Steam('MrLink', $httpClientProvider()))*
---------

**getProfile()**

```php
var_dump($FlawkApi->getProfile());

array(9) {
  ["gamerId64"]=>
  string(17) "76561197960273947"
  ["gamerId"]=>
  string(6) "MrLink"
  ["stateMessage"]=>
  string(6) "Online"
  ["onlineState"]=>
  string(6) "online"
  ["privacyState"]=>
  string(6) "public"
  ["visibilityState"]=>
  int(3)
  ["avatarIcon"]=>
  string(114) "http://media.steampowered.com/steamcommunity/public/images/avatars/ca/ca10b14c7aefc4a3d9f5a0018305f7f0e8698b82.jpg"
  ["avatarMedium"]=>
  string(121) "http://media.steampowered.com/steamcommunity/public/images/avatars/ca/ca10b14c7aefc4a3d9f5a0018305f7f0e8698b82_medium.jpg"
  ["avatarFull"]=>
  string(119) "http://media.steampowered.com/steamcommunity/public/images/avatars/ca/ca10b14c7aefc4a3d9f5a0018305f7f0e8698b82_full.jpg"
}
```

**getGames()**

```php
var_dump($FlawkApi->getGames());

array(1) {
  [1]=>
  array(8) {
    ["appID"]=>
    int(42710)
    ["name"]=>
    string(37) "Call of Duty: Black Ops - Multiplayer"
    ["logo"]=>
    string(114) "http://media.steampowered.com/steamcommunity/public/images/apps/42710/2b07ffc9e420c232858a60a20cdefeebaa9fd5c6.jpg"
    ["storeLink"]=>
    string(35) "http://steamcommunity.com/app/42710"
    ["hoursLast2Weeks"]=>
    float(15.8)
    ["hoursOnRecord"]=>
    float(453)
    ["statsLink"]=>
    string(62) "http://steamcommunity.com/id/MrLink/stats/CallOfDutyBlackOpsMP"
    ["globalStatsLink"]=>
    string(66) "http://steamcommunity.com/stats/CallOfDutyBlackOpsMP/achievements/"
  }
}
```

*more to come...*