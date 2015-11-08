<?php

define('TEST_ROOT',dirname(__FILE__).'/');
define('APP_ROOT',dirname(__FILE__).'/../networks/');
define('SSL_ROOT',dirname(__FILE__).'/../domain/');
define('PASS', '<div style="color:green;display:inline">pass</div>');
define('FAIL', '<div style="color:red;display:inline">fail</div>');


// define('DEBUG', true);
// if (DEBUG) {
// 	include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
// };

function load_json($name){
	$path = TEST_ROOT.'fixtures/'.$name.'.json';
	$file = fopen($path, "r") or die("Unable to open file! [".$path."]");
	$json = fread($file,filesize($path));
	fclose($file);
	return $json;
}

?>