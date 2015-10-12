<?php

include 'vars.php';
include ROOT.'shared/global.php';
include SECRET_FILE;

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
		return PREFIX.' ['.$tmp['social']['facebook']['aid'].']';
	};
};

function fb_verify_asset($verifications_json){
	$uidx = get_uid($verifications_json);
	$pidx = get_pid($verifications_json);
	if (!$pidx || !$uidx) {return false;};
	// echo "<br/>uid: [".$uidx."]"; 		
	// echo "<br/>pidx: [".$pidx."]";
	$postx = get_post($uidx,$pidx);
	// echo "<br/>post: [".$post."]"; 		
	$post_contentx = parse_post($postx);
	$expected_contentx = get_expected_text($verifications_json);
	$check = ($post_contentx==$expected_contentx)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	if (!$check) {
		$msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_contentx.'] but got ['.$post_contentx.']');
		echo "<br/>msg: [".$msg."]";
	};
	return $check;
}

?>