### Xbox Live Api Documentation 

##### Overview

This service implementation uses [XboxLeaders Public Api](http://xboxleaders.com/docs/api). It provides a public Api for the Xbox platform.

This service is <b>not</b> using Microsoft's official Developer Api and is instead using [XboxLeaders Public Api](http://xboxleaders.com/docs/api).
Which means any use [of] automated process or service (such as a bot, a spider, periodic caching of information stored by
Microsoft, or metasearching) to access or use the Service, or to copy or scrape data from the Service" is prohibited by the 
Xbox Live Terms of Service. Failure to adhere to the Xbox Live TOS can be punishable by having your Xbox Live account suspended
or banned from the Xbox Live service. The author is not responsible for the use of this implementation.

##### Usage
*(For more in-dept examples check out the /examples directory.)*

```php
<?php
// namespace for the Xbox Service
use FlawkApi\Services\Xbox;

// include FlawkApi bootstrap
require_once (__DIR__.'/bootstrap.php');

// FlawkClient() is the http client that comes with the FlawkApi package
$httpClientProvider = function(){
  return new \FlawkApi\Common\Http\Client\FlawkClient();
};

$FlawkApi = new Xbox("iTravers", $httpClientProvider);

```
Using the $FlawkApi object

```php
// using the getProfile() function
$profile = $FlawkApi->getProfile();

var_dump($profile["gamerId"]);

outputs:
["gamerId"]=> string(8) "iTravers"

```

##### Function List
*($FlawkApi = new Xbox("iTravers", $httpClientProvider()))*

**getProfile()**

```php
var_dump($FlawkApi->getProfile());

array(18) {
  ["tier"]=>
  string(4) "gold"
  ["isValid"]=>
  int(1)
  ["isBanned"]=>
  int(0)
  ["isOnline"]=>
  int(0)
  ["xblLaunchTeam"]=>
  int(0)
  ["nxeLaunchTeam"]=>
  int(0)
  ["kinectLaunchTeam"]=>
  int(0)
  ["avatarTile"]=>
  string(62) "https://avatar-ssl.xboxlive.com/global/t.4d4707d1/tile/0/2006a"
  ["avatarSmall"]=>
  string(58) "http://avatar.xboxlive.com/avatar/iTravers/avatarpic-s.png"
  ["avatarLarge"]=>
  string(58) "http://avatar.xboxlive.com/avatar/iTravers/avatarpic-l.png"
  ["avatarBody"]=>
  string(58) "http://avatar.xboxlive.com/avatar/iTravers/avatar-body.png"
  ["gamerId"]=>
  string(8) "iTravers"
  ["gamerScore"]=>
  int(3470)
  ["reputation"]=>
  int(20)
  ["name"]=>
  string(3) "Gav"
  ["motto"]=>
  string(0) ""
  ["location"]=>
  string(7) "Ireland"
  ["bio"]=>
  string(15) "Code of conduct"
}
```

**getAchievements()**

```php
var_dump($FlawkApi->getAchievements());

array(8) {
  ["gamerId"]=>
  string(8) "iTravers"
  ["avatarUrl"]=>
  string(62) "https://avatar-ssl.xboxlive.com/global/t.4d4707d1/tile/0/2006a"
  ["gameCount"]=>
  int(17)
  ["totalEarnedGamerScore"]=>
  int(3470)
  ["totalPossibleGamerScore"]=>
  int(14910)
  ["totalEarnedAchievements"]=>
  int(184)
  ["totalPossibleAchievements"]=>
  int(692)
  ["totalPercentCompleted"]=>
  int(26)
}
```

**getGames()**

```php
var_dump($FlawkApi->getGames());

array(1) {
  [1]=>
  array(12) {
    ["gameId"]=>
    string(10) "1096157387"
    ["gameTitle"]=>
    string(17) "Modern Warfare� 3"
    ["gameUrl"]=>
    string(50) "http://marketplace.xbox.com/en-US/Title/1096157387"
    ["apiAchievementsUrl"]=>
    string(63) "http://www.xboxleaders.com/api/achievements/itravers/1096157387"
    ["boxArt"]=>
    string(58) "http://www.xboxleaders.com/img/boxart/1096157387-small.jpg"
    ["boxArtLarge"]=>
    string(58) "http://www.xboxleaders.com/img/boxart/1096157387-large.jpg"
    ["earnedGamerScore"]=>
    int(335)
    ["possibleGamerScore"]=>
    int(1610)
    ["earnedAchievements"]=>
    int(26)
    ["possibleAchievements"]=>
    int(76)
    ["percentageCompleted"]=>
    int(27)
    ["lastPlayed"]=>
    string(10) "1351788168"
  }
}
```

*more to come...*