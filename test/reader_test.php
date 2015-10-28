<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include 'test_helper.php';
include '../json_reader.php';
// mimicking json from eyal
$json = load_json('verified');


$reader=new JsonReader($json);

// var_dump($reader);

$path = 'social,twitter,pid';
$twitter_pid_test = ($reader->get_path($path) == '651645990554968064') ? PASS : FAIL;
echo "<br/>twitter_pid_test: [".$twitter_pid_test."]";
if ($twitter_pid_test==FAIL) {var_dump($reader);}

$path = 'social,twitter,aid';
$twitter_aid_test = ($reader->get_path($path) == 'LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX') ? PASS : FAIL;
echo "<br/>twitter_aid_test: [".$twitter_aid_test."]";
if ($twitter_aid_test==FAIL) {var_dump($reader);}

$path = 'domain,url';
$bofa_url_test = ($reader->get_path($path) == 'https://www.bankofamerica.com') ? PASS : FAIL;
echo "<br/>bofa_url_test: [".$bofa_url_test."]";
if ($bofa_url_test==FAIL) {var_dump($reader);}

?>


