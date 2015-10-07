<?php

// include 'errors.php';

include 'twitter_consumer_data.php';
define('HOST','https://api.twitter.com');
define('TOKEN_FILE','twitter_bearer_token.txt');

function get_bearer_token(){
	// Step 1
	// step 1.1 - url encode the consumer_key and consumer_secret in accordance with RFC 1738
	$encoded_consumer_key = urlencode(CONSUMER_KEY);
	$encoded_consumer_secret = urlencode(CONSUMER_SECRET);
	// step 1.2 - concatinate encoded consumer, a colon character and the encoded consumer secret
	$bearer_token = $encoded_consumer_key.':'.$encoded_consumer_secret;
	// step 1.3 - base64-encode bearer token
	$base64_encoded_bearer_token = base64_encode($bearer_token);
	// step 2
	$url = "https://api.twitter.com/oauth2/token"; // url to send data to for authentication
	$headers = array( 
		"POST /oauth2/token HTTP/1.1", 
		"Host: api.twitter.com", 
		"User-Agent: jonhurlock Twitter Application-only OAuth App v.1",
		"Authorization: Basic ".$base64_encoded_bearer_token,
		"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	); 
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$url);  // set url to send to
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // set custom headers
	curl_setopt($ch, CURLOPT_POST, 1); // send as post
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); // post body/fields to be sent
	$header = curl_setopt($ch, CURLOPT_HEADER, 1); // send custom headers
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); // close the curl
	// echo $retrievedhtml;
	$output = explode("\n", $retrievedhtml);
	$bearer_token = '';
	foreach($output as $line)
	{
		if($line === false)
		{
			// there was no bearer token
		}else{
			$bearer_token = $line;
		}
	}
	$bearer_token = json_decode($bearer_token);
	return $bearer_token->{'access_token'};
}

function invalidate_bearer_token($bearer_token){
	$encoded_consumer_key = urlencode(CONSUMER_KEY);
	$encoded_consumer_secret = urlencode(CONSUMER_SECRET);
	$consumer_token = $encoded_consumer_key.':'.$encoded_consumer_secret;
	$base64_encoded_consumer_token = base64_encode($consumer_token);
	// step 2
	$url = "https://api.twitter.com/oauth2/invalidate_token"; // url to send data to for authentication
	$headers = array( 
		"POST /oauth2/invalidate_token HTTP/1.1", 
		"Host: api.twitter.com", 
		"User-Agent: jonhurlock Twitter Application-only OAuth App v.1",
		"Authorization: Basic ".$base64_encoded_consumer_token,
		"Accept: */*", 
		"Content-Type: application/x-www-form-urlencoded"
	); 
    
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$url);  // set url to send to
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // set custom headers
	curl_setopt($ch, CURLOPT_POST, 1); // send as post
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=".$bearer_token.""); // post body/fields to be sent
	$header = curl_setopt($ch, CURLOPT_HEADER, 1); // send custom headers
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); // close the curl
	return $retrievedhtml;
}

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
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$formed_url);  // set url to send to
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // set custom headers
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); // close the curl
	return $retrievedhtml;		
}

function parse_tweet($raw_tweet){
	$tmp = json_decode($raw_tweet,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['text'];
	};	
}
// get it from file, or from twitter api if file is empty
function fetch_bearer_token($path){
	$bearer_token_file = fopen($path, "a+") or die("Unable to open file!");
	$size = filesize($path);
	if ($size > 0) {
		$bearer_token = fread($bearer_token_file,$size);
	} else {
		$bearer_token = get_bearer_token();
		fwrite($bearer_token_file,$bearer_token); 
	};
	fclose($bearer_token_file);	
	return $bearer_token;
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
}

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
		return $tmp['social']['twitter']['text'];
	};
};

function twitter_verify_asset($verifications_json){
	$tweet_content = get_tweet(get_tweet_id($verifications_json));
	$expected_content = get_expected_text($verifications_json);
	$check = ($tweet_content==$expected_content)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	$msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_content.'] but got ['.$tweet_content.']');
	return $check;
}

// echo "The tweet is <hr/>".get_tweet('649137197539565568').'<hr/>';
// mimicking json from eyal
$path = 'verifications.json';
$verifications_file = fopen($path, "r") or die("Unable to open file!");
$verifications_json = fread($verifications_file,filesize($path));
fclose($verifications_file);

// echo "json tweet is <hr/>".get_tweet(get_tweet_id($verifications_json)).'<hr/>';
// echo "foo";
echo "Verified?: [".twitter_verify_asset($verifications_json).']';

?>