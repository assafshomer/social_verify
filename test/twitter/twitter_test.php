<?php

// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include $_SERVER['DOCUMENT_ROOT'].'/verify/twitter/verify_twitter.php';
include '../test_helper.php';
// mimicking json from eyal
$verified_path = '../verified.json';
$verified_file = fopen($verified_path, "r") or die("Unable to open file!");
$verified_json = fread($verified_file,filesize($verified_path));
fclose($verified_file);

$unverified_path = '../unverified.json';
$unverified_file = fopen($unverified_path, "r") or die("Unable to open file!");
$unverified_json = fread($unverified_file,filesize($unverified_path));
fclose($unverified_file);

$verified_test = (twitter_verify_asset($verified_json) == 1) ? PASS:FAIL;
$unverified_test = (twitter_verify_asset($unverified_json) <> 1) ? PASS:FAIL;

echo "verified_test: [".$verified_test."]<br/>";
echo "unverified_test: [".$unverified_test.']';

?>