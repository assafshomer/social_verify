<?php

include 'vars.php';
include SECRET_FILE;

// include ROOT.'/shared/errors.php';
$shortTermAccessToken = fetch_access_token(SHORT_TERM_TOKEN_FILE);

echo "<br/> Extended Access Token [".extend_access_token($shortTermAccessToken).']';


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
};

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
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch);
	$output = explode("=", $retrievedhtml);
	$token = explode("&", $output[1])[0];
	return $token;
};

?>