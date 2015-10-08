<?php

// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';

include './test_helper.php';
include $_SERVER['DOCUMENT_ROOT'].'/verify/fb/verify_post.php';
include $_SERVER['DOCUMENT_ROOT'].'/verify/fb/get_access_token.php';
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
$uid = get_uid($verified_json);
$accesstoken = fetch_access_token(TOKEN_FILE);
$post = get_post($uid,$pid);
$ct = json_decode($post,TRUE)['created_time'];
$er = json_decode($post,TRUE)['error']['message'];
// TESTS
// $var_test = ()? PASS:FAIL;

$verified_test = (fb_verify_asset($verified_json) == 1) ? PASS:FAIL;
$unverified_test = (fb_verify_asset($unverified_json) <> 1) ? PASS:FAIL;
$pid_test = ($pid == 145466885806040) ? PASS:FAIL;
$uid_test = ($uid == 100010281887017) ? PASS:FAIL;
$accesstoken_test = (strlen($accesstoken) > 100)? PASS:FAIL;
$expected_text = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",get_expected_text($verified_json)))?PASS:FAIL;
// 2015-10-06T08:28:06+0000
$getpost_test = (strlen($ct) == 24)? PASS:FAIL;
$content_test = (preg_match("/LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX/",parse_post($post)))?PASS:FAIL;
$error_test = (preg_match("/Error validating access token/",$er))?FAIL:PASS;


// OUTPUT

echo "<br/>verified_test: [".$verified_test."]";
echo "<br/>unverified_test: [".$unverified_test."]";
echo "<br/>post id from json: [".$pid_test."]";
echo "<br/>user id from json: [".$uid_test."]";
echo "<br/>access token from file: [".$accesstoken_test."]";
echo "<br/>expected txt [".$expected_text."]";
echo "<br/>getpost: [".$getpost_test."]";
echo "<br/>post content: [".$content_test."]";
echo "<br/>error test: [".$error_test."]";

// AUX OUTPUTS
// echo "<br/>post: [".$post."]";
// echo "<br/>ca: [".$ct."]";
$print_error=($error_test==FAIL)?"<br/>error: [".$er."]":'';
echo $print_error;
?>