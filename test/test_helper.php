<?php

define('PASS', '<div style="color:green;display:inline">pass</div>');
define('FAIL', '<div style="color:red;display:inline">fail</div>');

function load_json($name){
	$path = './fixtures/'.$name.'.json';
	$file = fopen($path, "r") or die("Unable to open file!");
	$json = fread($file,filesize($path));
	fclose($file);
	return $json;
}

?>