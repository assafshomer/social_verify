<?php

define('ROOT',$_SERVER['DOCUMENT_ROOT'].'/verify/');
define('TOKEN_FILE',ROOT.'fb/fb_access_token.txt');
define('SECRET_FILE',ROOT.'fb/fb_app_secrets.php');
include SECRET_FILE;
include ROOT.'/shared/errors.php';
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

// define('FACEBOOK_SDK_V4_SRC_DIR', ROOT+'vendor/facebook/php-sdk-v4/src/Facebook/');
// require_once ROOT+'vendor/facebook/php-sdk-v4/autoload.php';

// // Make sure to load the Facebook SDK for PHP via composer or manually

// use Facebook\FacebookSession;
// // add other classes you plan to use, e.g.:
// // use Facebook\FacebookRequest;
// // use Facebook\GraphUser;
// // use Facebook\FacebookRequestException;

// FacebookSession::setDefaultApplication(FB_APP_ID, FB_APP_SECRET);

// // OAuth 2.0 client handler
// $oAuth2Client = $fb->getOAuth2Client();

// // Exchanges a short-lived access token for a long-lived one https://developers.facebook.com/docs/php/gettingstarted/5.0.0
// $newAccessToken = $oAuth2Client->requestAnAccessToken($accessToken);

// echo "<br/> current Access Token<br/>[".$accessToken.']'; 
// echo "<br/> New Long Lived Access Token<br/>[".$newAccessToken.']';



?>