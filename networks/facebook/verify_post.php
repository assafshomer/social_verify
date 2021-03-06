<?php

include 'vars.php';
include ROOT.'shared/global.php';
include SECRET_FILE;

// function get_post($uid,$pid){
// 	$endpoint = '/'.$uid.'_'.$pid;
// 	$url = HOST.$endpoint;
// 	$params = '?access_token='.FB_APP_TOKEN;
// 	$formed_url = $url.$params;
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL,$formed_url);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	$retrievedhtml = curl_exec ($ch);
// 	curl_close($ch); 
// 	return $retrievedhtml;		
// };

function get_post_with_token($uid,$pid,$token){
	$endpoint = '/'.$uid.'_'.$pid;
	$url = HOST.$endpoint;
	$params = '?access_token='.$token;
	$formed_url = $url.$params;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch); 
	return $retrievedhtml;		
};

function get_post($uid,$pid){
	return 	get_post_with_token($uid,$pid,FB_APP_TOKEN);
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
		return PREFIX.' ['.$tmp['social']['facebook']['aid'].']';
	};
};

function fb_verify_asset($verifications_json){
	return fb_verify_asset_with_token($verifications_json,FB_APP_TOKEN);
};

function fb_verify_asset_with_token($verifications_json,$token){
	$uidx = get_uid($verifications_json);
	$pidx = get_pid($verifications_json);
	if (!$pidx || !$uidx) {return false;};
	$postx = get_post_with_token($uidx,$pidx,$token);
	$post_contentx = parse_post($postx);
	$expected_contentx = get_expected_text($verifications_json);
	$check = ($post_contentx==$expected_contentx)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	if (!$check) {
		$msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_contentx.'] but got ['.$post_contentx.']');
		echo "<br/>msg: [".$msg."]";
	};
	return $check;
};

?>