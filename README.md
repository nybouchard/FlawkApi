### FlawkApi
===========

FlawkApi is a full featured PHP5.3+ Api library for popular gaming platforms (Xbox Live, Playstation Network, Steam). FlawkApi is easily implemented with any projects.

*NOTE: Please be aware many components and interfaces are subject to change until official release.*

##### Overview

 - PSR-0 Compliant Autoloader
 - Built for future additions and other services
 - Changeable HTTP client, FlawkApi\Common\Http\Client\ClientInterface
 - ([SOLID](http://en.wikipedia.org/wiki/SOLID_(object-oriented_design)), readable, documented code

##### In Development

 - Unit Tests
 - New Features on existing services and new services
 - External Sign in for existing services
 - More to come

##### Examples

Vist the /docs folder for more indept examples/documentation of the FlawkApi.

```php
<?php
// namespace for all the Services
use FlawkApi\Services\Playstation;
use FlawkApi\Services\Xbox;
use FlawkApi\Services\Steam;

// include FlawkApi bootstrap
require_once (__DIR__.'/bootstrap.php');

// FlawkClient() is the http client that comes with the FlawkApi package
$httpClientProvider = function(){
  return new \FlawkApi\Common\Http\Client\FlawkClient();
};

$playstation = new Playstation("Carlosvaldosta", $httpClientProvider);
$xbox = new Xbox("iTravers", $httpClientProvider);
$steam = new Steam("MrLink", $httpClientProvider);
```