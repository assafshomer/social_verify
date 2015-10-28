<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include APP_ROOT.'facebook/verify_post_oo.php';
// include APP_ROOT.'facebook/get_access_token.php';
// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');
$user2_json = load_json('user2');
$user3_json = load_json('user3');

$verified = new FacebookVerifier($verified_json);
$verified_test = ($verified->verified) ? PASS:FAIL;
echo "<br/>verified_test: [".$verified_test."]";

$unverified = new FacebookVerifier($unverified_json);
$unverified_test = (!$unverified->verified) ? PASS:FAIL;
echo "<br/>unverified_test: [".$unverified_test."]";

$fake_networks = new FacebookVerifier($fake_networks_json);
$fake_networks_test = (!$fake_networks->verified) ? PASS:FAIL;
echo "<br/>fake_networks_test: [".$fake_networks_test."]";

$user2 = new FacebookVerifier($user2_json);
$user2_test = ($user2->verified) ? PASS:FAIL;
echo "<br/>user2_test: [".$user2_test."]";

$user3 = new FacebookVerifier($user3_json);
$user3_test = ($user3->verified) ? PASS:FAIL;
echo "<br/>user3_test: [".$user3_test."]";

echo "<hr/>";

?>
