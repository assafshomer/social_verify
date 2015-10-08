<?php

include 'fb_get_token.php';
define('HOST','https://graph.facebook.com');

function get_post($uid,$pid){
	$endpoint = '/'.$uid.'_'.$pid;
	$url = HOST.$endpoint;
	$params = '?access_token='.FB_APP_TOKEN;
	$formed_url = $url.$params;
	$ch = curl_init();  // setup a curl
	curl_setopt($ch, CURLOPT_URL,$formed_url);  // set url to send to
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
	$retrievedhtml = curl_exec ($ch); // execute the curl
	curl_close($ch); 
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
		return $tmp['social']['facebook']['text'];
	};
};

function fb_verify_asset($verifications_json){
	$uid = get_uid($verifications_json);
	$pid = get_pid($verifications_json);	
	$post_content = parse_post(get_post($uid,$pid));
	$expected_content = get_expected_text($verifications_json);
	$check = ($post_content==$expected_content)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	// $msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_content.'] but got ['.$post_content.']');
	// echo "<br/>msg: [".$msg."]";
	return $check;
}

?>