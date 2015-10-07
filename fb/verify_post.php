<?php

include 'fb_get_token.php';
define('HOST','https://graph.facebook.com');

function get_post_by_id($uid,$pid){
	$endpoint = '/'.$uid.'_'.$pid;
	$url = HOST.$endpoint;
	$access_token = fetch_access_token(TOKEN_FILE);
	// $access_token = FB_APP_ID.'|'.FB_APP_SECRET;
	// echo "<br/>access_token: [".$access_token.']';
	$params = '?access_token='.$access_token;
	$formed_url = $url.$params;
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$formed_url);  // set url to send to
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); // close the curl
	// echo "<br/>".$retrievedhtml;
	// echo "<br/>".json_decode($retrievedhtml,TRUE)['message'];
	return $retrievedhtml;		
};

function parse_post($raw_post){
	$tmp = json_decode($raw_post,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['message'];
	};	
};

function get_post($post_id){
	$bearer_token = fetch_bearer_token(TOKEN_FILE);
	$tweet = get_raw_tweet_by_id($bearer_token,$tweet_id);
	// $tweet = get_tweet_by_id($bearer_token,'649137197539');
	try {
		return parse_tweet($tweet);
	} catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	};	
};

function get_pid($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['facebook']['pid'];
	};
};

function get_uid($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['facebook']['uid'];
	};
};

function get_expected_text($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['fb']['text'];
	};
};

function fb_verify_asset($verifications_json){
	return TRUE;
}

?>