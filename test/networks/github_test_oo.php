<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include APP_ROOT.'github/verify_gist_oo.php';
// include APP_ROOT.'facebook/get_access_token.php';
// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');

$verified = new GithubVerifier($verified_json);
$verified_test = ($verified->verified) ? PASS:FAIL;
echo "<br/>verified_test: [".$verified_test."]";

$unverified = new GithubVerifier($unverified_json);
$unverified_test = (!$unverified->verified) ? PASS:FAIL;
echo "<br/>unverified_test: [".$unverified_test."]";

$fake_networks = new GithubVerifier($fake_networks_json);
$fake_networks_test = (!$fake_networks->verified) ? PASS:FAIL;
echo "<br/>fake_networks_test: [".$fake_networks_test."]";


echo "<hr/>";

?>
