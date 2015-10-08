<?php

include 'vars.php';

function get_gist($pid){
	$endpoint = '/'.$pid;
	$formed_url = HOST.$endpoint;
	$headers = array( 
		"GET ".$endpoint." HTTP/1.1", 
		"Host: ".HOST, 
		"User-Agent: Colu Asset Verificator"
	);	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch); 
	return $retrievedhtml;		
};

function parse_gist($raw_gist){
	$tmp = json_decode($raw_gist,TRUE);
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
		return $tmp['social']['github']['pid'];
	};
};

function get_uid($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['github']['uid'];
	};
};

function get_expected_text($json){
	$tmp = json_decode($json,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['social']['github']['text'];
	};
};

function github_verify_asset($verifications_json){
	$uid = get_uid($verifications_json);
	$pid = get_pid($verifications_json);	
	$gist_content = parse_gist(get_gist($uid,$pid));
	$expected_content = get_expected_text($verifications_json);
	$check = ($gist_content==$expected_content)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	// $msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_content.'] but got ['.$gist_content.']');
	// echo "<br/>msg: [".$msg."]";
	return $check;
}

?>