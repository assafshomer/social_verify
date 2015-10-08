<?php

include 'vars.php';
include SECRET_FILE;

// include ROOT.'/shared/errors.php';
$accessToken = fetch_access_token(TOKEN_FILE);
// $accessToken = '1624529804474003|D3cf6KRK-zhfvgASwRRfieUqtSw';

function extend_access_token($short_term_access_token){
	// https://developers.facebook.com/docs/facebook-login/access-tokens#extending
	$encoded_app_id = urlencode(FB_APP_ID);
	$encoded_app_secret = urlencode(FB_APP_SECRET);
	$base_url = HOST."/oauth/access_token?";
	$params = array( 
	  'grant_type'=>'fb_exchange_token',          
    'client_id'=>$encoded_app_id,
    'client_secret'=>$encoded_app_secret,
    'fb_exchange_token'=>$short_term_access_token
	);
	$formed_params = http_build_query($params);
	$formed_url = $base_url.$formed_params;
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$formed_url);  // set url to send to
	curl_setopt($ch, CURLOPT_POST, 1); // send as post
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); // close the curl
	$output = explode("=", $retrievedhtml);
	$token = explode("&", $output[1])[0];
	return $token;
};

function fetch_access_token($path){
	$access_token_file = fopen($path, "a+") or die("Unable to open file!");
	$size = filesize($path);
	if ($size > 0) {
		$access_token = fread($access_token_file,$size);
	} else {
		$msg = 'invalid access token';
    throw new Exception($msg);		
	};
	fclose($access_token_file);	
	return $access_token;	
}

?>