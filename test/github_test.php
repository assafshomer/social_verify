<?php

include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';

include './test_helper.php';
include $_SERVER['DOCUMENT_ROOT'].'/verify/github/verify_gist.php';
// mimicking json from eyal
$verified_path = './fixtures/verified.json';
$verified_file = fopen($verified_path, "r") or die("Unable to open file!");
$verified_json = fread($verified_file,filesize($verified_path));
fclose($verified_file);

$unverified_path = './fixtures/unverified.json';
$unverified_file = fopen($unverified_path, "r") or die("Unable to open file!");
$unverified_json = fread($unverified_file,filesize($unverified_path));
fclose($unverified_file);

$pid = get_pid($verified_json);
$gist = get_gist($pid);
// // $er = json_decode($gist,TRUE)['error']['message'];
// // TESTS
// // $var_test = ()? PASS:FAIL;

// $verified_test = (github_verify_asset($verified_json) == 1) ? PASS:FAIL;
// $unverified_test = (github_verify_asset($unverified_json) <> 1) ? PASS:FAIL;
$pid_test = ($pid == '6c704f5759927212e714') ? PASS:FAIL;
// $expected_text = (strlen(get_expected_text($verified_json))>10)?PASS:FAIL;
$expected_text = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",get_expected_text($verified_json)))?PASS:FAIL;
// // 2015-10-06T08:28:06+0000
// $getgist_test = (strlen($ct) == 24)? PASS:FAIL;
$content_test = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",parse_gist($gist)))?PASS:FAIL;
// // $error_test = (preg_match("/Error validating access token/",$er))?FAIL:PASS;


// // OUTPUT

echo "<br/>gist id from json: [".$pid_test."]";
// echo "<br/>verified_test: [".$verified_test."]";
// echo "<br/>unverified_test: [".$unverified_test."]";

// echo "<br/>access token from file: [".$accesstoken_test."]";
echo "<br/>expected txt [".$expected_text."]";
// echo "<br/>getgist: [".$getgist_test."]";
echo "<br/>gist content: [".$content_test."]";
// echo "<br/>error test: [".$error_test."]";

// AUX OUTPUTS
echo "<br/>gist: [".$gist."]";
// // echo "<br/>ca: [".$ct."]";
// $print_error=($error_test==FAIL)?"<br/>error: [".$er."]":'';
// echo $print_error;
?>