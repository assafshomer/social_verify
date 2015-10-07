<?php

define('ROOT',$_SERVER['DOCUMENT_ROOT'].'/verify/fb/');
define('TOKEN_FILE',ROOT.'fb_access_token.txt');
define('SECRET_FILE',ROOT.'fb_app_secrets.php');
include SECRET_FILE;
include ROOT.'/shared/errors.php';
$access_token = fetch_access_token(TOKEN_FILE);
// $access_token = '1624529804474003|D3cf6KRK-zhfvgASwRRfieUqtSw';
// require_once $_SERVER['DOCUMENT_ROOT'].'/verify' . '/vendor/autoload.php';

// $fb = new Facebook\Facebook([
//   'app_id' => FB_APP_ID,
//   'app_secret' => FB_APP_SECRET,
//   'default_graph_version' => 'v2.2',
//   ]);

// // OAuth 2.0 client handler
// $oAuth2Client = $fb->getOAuth2Client();

// // Exchanges a short-lived access token for a long-lived one https://developers.facebook.com/docs/php/gettingstarted/5.0.0
// $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($access_token);

// echo "New Long Lived Access Token<br/>[".$longLivedAccessToken.']';

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