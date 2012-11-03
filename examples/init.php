<?php

$gamerIds = array(
  'playstation' => 
    array(
      'id' => 'Carlosvaldosta'
    ),
  'xbox' => 
    array(
      'id' => 'iTravers'
    ),
  'steam' => 
    array(
      'id' => 'MrLink'
    )
);

$httpClientProvider = function(){
  return new \FlawkApi\Common\Http\Client\FlawkClient();
};