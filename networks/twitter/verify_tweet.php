<?php

include 'vars.php';
include ROOT.'shared/global.php';
include 'twitter_get_tokens.php';

fetch_bearer_token(TOKEN_FILE);

function get_raw_tweet_by_id($bearer_token, $tweet_id){
	$endpoint = '/1.1/statuses/show.json';
	$url = HOST.$endpoint;
	$params = '?id='.$tweet_id;
	$headers = array( 
		"GET ".$endpoint.$params." HTTP/1.1", 
		"Host: api.twitter.com", 
		"User-Agent: colu Twitter Application-only OAuth App v.1",
		"Authorization: Bearer ".$bearer_token
	);
	$formed_url = $url.$params;
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL,$formed_url);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$retrievedhtml = curl_exec ($ch); 
	curl_close($ch); 
	return $retrievedhtml;		
};

function parse_tweet($raw_tweet){
	$tmp = json_decode($raw_tweet,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['text'];
	};	
};

function get_tweet($tweet_id){
	$bearer_token = fetch_bearer_token(TOKEN_FILE);
	$tweet = get_raw_tweet_by_id($bearer_token,$tweet_id);
	// $tweet = get_tweet_by_id($bearer_token,'649137197539');
	try {
		return parse_tweet($tweet);
	} catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	};	
};

function get_tweet_id($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['twitter']['pid'];
	};
};

function get_expected_text($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return PREFIX.' ['.$tmp['social']['twitter']['aid'].']';
	};
};

function twitter_verify_asset($verifications_json){	
	$tweet_content = get_tweet(get_tweet_id($verifications_json));
	$expected_content = get_expected_text($verifications_json);
	$check = ($tweet_content==$expected_content)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	$msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_content.'] but got ['.$tweet_content.']');
	// echo "<br/>".$msg; 
	return $check;
}

?>