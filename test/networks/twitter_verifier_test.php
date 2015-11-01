<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include APP_ROOT.'twitter/twitter_verifier.php';
// mimicking json from eyal
$verified_json = load_json('verified');
$verified_2_json = load_json('verified_2');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');

$verified = new TwitterVerifier($verified_json);
$verified_test = ($verified->verified) ? PASS:FAIL;
echo "<br/>verified_test: [".$verified_test."]";

$verified_2 = new TwitterVerifier($verified_2_json);
$verified_2_test = ($verified_2->verified) ? PASS:FAIL;
echo "<br/>verified_2_test: [".$verified_2_test."]";

$unverified = new TwitterVerifier($unverified_json);
$unverified_test = (!$unverified->verified) ? PASS:FAIL;
echo "<br/>unverified_test: [".$unverified_test."]";

$fake = new TwitterVerifier($fake_json);
$fake_test = (!$fake->verified) ? PASS:FAIL;
echo "<br/>fake_test: [".$fake_test."]";

?>