<?php

// include 'vars.php';
include SECRET_FILE;

function get_bearer_token(){
	$encoded_consumer_key = urlencode(CONSUMER_KEY);
	$encoded_consumer_secret = urlencode(CONSUMER_SECRET);
	$bearer_token = $encoded_consumer_key.':'.$encoded_consumer_secret;
	$base64_encoded_bearer_token = base64_encode($bearer_token);
	$url = "https://api.twitter.com/oauth2/token"; // url to send data to for authentication
	$headers = array( 
		"POST /oauth2/token HTTP/1.1", 
		"Host: api.twitter.com", 
		"User-Agent: jonhurlock Twitter Application-only OAuth App v.1",
		"Authorization: Basic ".$base64_encoded_bearer_token,
		"Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
	); 
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL,$url);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); 
	$header = curl_setopt($ch, CURLOPT_HEADER, 1); 
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	$retrievedhtml = curl_exec ($ch); 
	curl_close($ch); 
	// echo "retrievedhtml: [".$retrievedhtml."]<br/>"; 
	$output = explode("\n", $retrievedhtml);
	// var_dump($output);
	$bearer_token = '';
	foreach($output as $line)
	{
		if($line === false)
		{
			// there was no bearer token
		}else{
			$a = json_decode($line,TRUE);
			if (is_array($a) && array_key_exists('access_token', $a)) {
				$bearer_token = json_decode($line,TRUE)['access_token'];	
			 }			
		}
	};
	return $bearer_token;
};

// get it from file, or from twitter api if file is empty
function fetch_bearer_token($path){
	$bearer_token_file = fopen($path, "w+") or die("Unable to open file! [".$path."]");
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
?>