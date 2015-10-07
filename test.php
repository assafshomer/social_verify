<?php
echo "foo</br>";
for($i = 0; $i < 10; $i++) {
	echo $i . "</br>";
}
include 'errors.php';
// (TRUE) ? echo 'assaf': echo 'shomer';

// $bar = {"errors":[{"code":144,"message":"No status found with that ID."}]};
// echo json_decode($bar,TRUE);
// $path = 'verifications.json';
// $verifications_file = fopen($path, "r") or die("Unable to open file!");
// $verifications_json = fread($verifications_file,filesize($path));
// fclose($verifications_file);
// // echo $verifications_json;
// // echo $verifications_json['token_type'];
// $text = json_decode($verifications_json,TRUE)['social']['twitter']['text'];
// echo '['.$text.']';
$foo = 1;
$bar = 2;
$buzz = ($foo == $bar ?TRUE:FALSE);
$buzz ? ;


?>