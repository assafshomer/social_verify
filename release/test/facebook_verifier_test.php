<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include 'test_helper.php';
include '../social/facebook_verifier.php';

$verified_json = file_get_contents('fixtures/verified.json');
$unverified_json = file_get_contents('fixtures/unverified.json');
$fake_networks_json = file_get_contents('fixtures/fake_networks.json');
$user2_json = file_get_contents('fixtures/user2.json');
$user3_json = file_get_contents('fixtures/user3.json');

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
