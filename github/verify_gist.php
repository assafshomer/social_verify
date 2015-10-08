<?php

include 'vars.php';
include SECRET_FILE;

function get_gist($pid){
	$endpoint = '/gists/'.$pid;
	$formed_url = HOST.$endpoint;
	// echo "<br/>apiurl: [".$formed_url."]";
	$headers = array( 
		"GET ".$endpoint." HTTP/1.1", 
		"Host: ".HOST.'/gists/', 
		"User-Agent: Colu Asset Verificator"
	);	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch);
	// echo $retrievedhtml; 
	return $retrievedhtml;		
};

function parse_gist($raw_gist){
	$tmp = json_decode($raw_gist,TRUE);
	$error_message = $tmp['errors'][0]['message'];
	if (strlen($error_message)>0) {
		return $error_message;
	} else {
		return $tmp['files']['gistfile1.txt']['content'];
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
	$pid = get_pid($verifications_json);	
	$gist_content = parse_gist(get_gist($pid));
	$expected_content = get_expected_text($verifications_json);
	$check = ($gist_content==$expected_content)?TRUE:FALSE;
	// Eyal, I think we should log the following msg
	// $msg = ($check ? 'Asset is verified': 'Asset verification failed. Expected ['.$expected_content.'] but got ['.$gist_content.']');
	// echo "<br/>msg: [".$msg."]";
	return $check;
}

?>