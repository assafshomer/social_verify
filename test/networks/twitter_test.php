<?php

include '../test_helper.php';
include APP_ROOT.'twitter/verify_twit.php';
// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');

$verified_test = (twitter_verify_asset($verified_json) == 1) ? PASS:FAIL;
$unverified_test = (twitter_verify_asset($unverified_json) <> 1) ? PASS:FAIL;
$fake_networks_test = (twitter_verify_asset($fake_networks_json) <> 1) ? PASS:FAIL;

echo "verified_test: [".$verified_test."]<br/>";
echo "unverified_test: [".$unverified_test.']<br/>';
echo "fake_networks_test: [".$fake_networks_test.']<br/>';

?>