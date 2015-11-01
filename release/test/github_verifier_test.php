<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include 'test_helper.php';
include '../social/github_verifier.php';

$verified_json = file_get_contents('fixtures/verified.json');
$unverified_json = file_get_contents('fixtures/unverified.json');
$fake_networks_json = file_get_contents('fixtures/fake_networks.json');

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
