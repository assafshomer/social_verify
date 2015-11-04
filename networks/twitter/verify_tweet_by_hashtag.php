<?php 

require_once('TwitterAPIExchange.php');


// @coloredcoinstap 

$settings = array(
    'oauth_access_token' => "3746211499-jWBWTlc2LTupFBHS3LLEis4WBu7h3FNEliwy7XB",
    'oauth_access_token_secret' => "zJsJxlPHazeRHayeqHjrAR0oabzBFgRc0E6POHbngY3YL",
    'consumer_key' => "GHOeTURvHLcpKgHCnFnzJ1n52",
    'consumer_secret' => "lAa4VxASl3y3GjxKBOPF4YVhmG5zs7y84CDqU14g0N77izjrAW"
);

$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';
$aid = 'U3uPyQeyNRafPy7popDfhZui8Hsw98B5XMUpP';
$username = 'zzz';
$getfield = '?q=#'.$aid;

$twitter = new TwitterAPIExchange($settings);
$json = ($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest());

$data = json_decode($json,TRUE);

// var_dump($data);

var_dump($data['statuses'][0]['text']);
var_dump($data['statuses'][0]['user']['screen_name']);

?>
