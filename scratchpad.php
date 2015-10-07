<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
echo "foo</br>";
// for($i = 0; $i < 10; $i++) {
// 	echo $i . "</br>";
// }
$path = 'scratchpad.json';
$jsonfile = fopen($path, "a+") or die("Unable to open file!");
$size = filesize($path);
$json = fread($jsonfile,$size);
echo "<br/>".$json;
echo "<br/>".json_decode($json,TRUE)['token_type'];
echo "<br/>".json_decode($json,TRUE);

echo "<br/>".$_SERVER['DOCUMENT_ROOT'];

?>