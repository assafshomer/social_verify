<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include './fb_app_secrets.php';

// $fb = new Facebook\Facebook([
//   'app_id' => FB_APP_ID,
//   'app_secret' => FB_APP_SECRET,
//   'default_graph_version' => 'v2.4',
// ]);



// Set Extended Access Token
$facebook->setExtendedAccessToken();

// Get access short live access token
$accessToken = $facebook->getAccessToken();

// Exchange token
$facebook->api('/oauth/access_token', 'POST',
    array(  
        'grant_type' => 'fb_exchange_token',           
        'client_id' => '1624529804474003',
        'client_secret' => 'ecceb06005517ea305cbc2d4917e8976',
        'fb_exchange_token' => $accessToken
    )
);


echo $accessToken;

?>