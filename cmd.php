<?php

// function verify_chain($array){
// 	$array=array_unique($array);
// 	if (count($array) == 1 && $array[0]=='good') {
// 		return true;
// 	} else {
// 		return false;
// 	};	
// }

// $stack = array('good');
// array_push($stack, "good", "good");
// echo verify_chain($stack);
for ($x = 0; $x <= 2; $x++) {
    echo "The number is: $x\n";
} 
// echo "docroot:[".$_SERVER['DOCUMENT_ROOT']."]";
// echo dirname(__FILE__);
// $path = dirname(__FILE__).'/foo.html';
// $txt="<!DOCTYPE html><html><head><title>VERIFICATION TESTING</title></head><body>";
// $txt=$txt."<br/>array_test: [".$array_test."]";
// $txt=$txt."<br/>load_cert_test: [".$load_cert_test."]";
// $txt=$txt."<br/>get_url_test: [".$get_url_test."]";
// $txt=$txt."<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";
// $txt=$txt."<br/>bofa_test: [".$bofa_test."]";
// $txt=$txt."<br/>wf_test: [".$wf_test."]";
// $txt=$txt."<hr/>";
// $txt=$txt."<br/>chain_length: [".$chain_length."]";

// $file = fopen($path, "w+") or die("Unable to open file ".$path);
// fwrite($file, $txt);
// fclose($file);
$string='*.cert-002.blockchain.info';
$tmp=explode('.',$string);
array_shift($tmp);
var_dump($tmp);
echo implode(".", $tmp);
// echo preg_replace("/^(www\.|\*.)/", '', $string);





?>