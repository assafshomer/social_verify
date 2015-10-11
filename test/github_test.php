<?php

include './test_helper.php';
include $_SERVER['DOCUMENT_ROOT'].'/verify/networks/github/verify_gist.php';
// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');

$pid = get_pid($verified_json);
$gist = get_gist_with_oauth($pid);
$fu = json_decode($gist,TRUE)['forks_url'];
$er = json_decode($gist,TRUE)['error']['message'];

// TESTS
// $var_test = ()? PASS:FAIL;

$verified_test = (github_verify_asset($verified_json) == 1) ? PASS:FAIL;
$unverified_test = (github_verify_asset($unverified_json) <> 1) ? PASS:FAIL;
$fake_networks_test = (github_verify_asset($fake_networks_json) <> 1) ? PASS:FAIL;
$pid_test = ($pid == '6c704f5759927212e714') ? PASS:FAIL;
$expected_text = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",get_expected_text($verified_json)))?PASS:FAIL;
$jsonkeys_test = (preg_match("/https\:\/\/api\.github\.com\/gists\/.*\/forks/",$fu))?PASS:FAIL;
$content_test = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",parse_gist($gist)))?PASS:FAIL;
$error_test = (preg_match("/Error/i",$er))?FAIL:PASS;


// OUTPUT


echo "<br/>verified_test: [".$verified_test."]";
echo "<br/>unverified_test: [".$unverified_test."]";
echo "<br/>fake_networks_test: [".$fake_networks_test."]";
echo "<br/>gist id from json: [".$pid_test."]";
echo "<br/>expected txt [".$expected_text."]";
echo "<br/>jsonkeys_test: [".$jsonkeys_test."]";
echo "<br/>gist content: [".$content_test."]";
echo "<br/>error test: [".$error_test."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";


$print_error=($error_test==FAIL)?"<br/>error: [".$er."]":'';
echo $print_error;
?>

