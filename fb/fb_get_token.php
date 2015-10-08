<?php

define('ROOT',$_SERVER['DOCUMENT_ROOT'].'/verify/');
define('TOKEN_FILE',ROOT.'fb/fb_access_token.txt');
define('SECRET_FILE',ROOT.'fb/fb_app_secrets.php');
include SECRET_FILE;
// include ROOT.'/shared/errors.php';
$accessToken = fetch_access_token(TOKEN_FILE);

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