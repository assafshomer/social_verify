<?php
define('TEST_ROOT',dirname(__FILE__).'/');
define('APP_ROOT',$_SERVER['DOCUMENT_ROOT'].'/verify/networks/');
define('SSL_ROOT',$_SERVER['DOCUMENT_ROOT'].'/verify/domain/openssl/');
define('PASS', '<div style="color:green;display:inline">pass</div>');
define('FAIL', '<div style="color:red;display:inline">fail</div>');
define('DEBUG', FALSE);
define('HEADER',"<!DOCTYPE html><html><head><title>VERIFICATION TESTING</title></head><body><h1>DOMAIN TESTING</h1>");

if (DEBUG) {
	include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
};

function load_json($name){
	$path = TEST_ROOT.'fixtures/'.$name.'.json';
	$file = fopen($path, "r") or die("Unable to open file!");
	$json = fread($file,filesize($path));
	fclose($file);
	return $json;
}

?>