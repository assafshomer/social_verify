<?php

// include '../test_helper.php';
include '/var/www/html/verify/test/test_helper.php';
// include SSL_ROOT.'verify_ssl.php';
include '/var/www/html/verify/domain/openssl/verify_ssl.php';
$results_file_path = TEST_ROOT.'/test_results.html';

// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');
$bofa_url = 'https://www.bankofamerica.com';

// VARS
$good_array=array('good','good','good');
$bad_array=array('good','good','bad');
$chain_length = load_certificate_chain($bofa_url);

// BANK OF AMERICA
$bofa=verify_domain($bofa_url);

// WELLS FARGO
$wf_url = 'https://www.wellsfargo.com';
$wf=verify_domain($wf_url);

// GITHUB
$github_url = 'https://github.com';
$github=verify_domain($github_url);

$get_url_test = (get_url($verified_json)==$bofa_url)?PASS:FAIL;
$get_domain_from_url_test = (get_domain_from_url($bofa_url) == 'www.bankofamerica.com' )?PASS:FAIL;

$bofa_test = ($bofa["company_name"]== "Bank of America Corporation" 
	&&	$bofa["company_url"]=='www.bankofamerica.com'
	&&	$bofa["verification_result"]=='PASS'
	// &&	$bofa["url_matching"]=='TRUE'
)?PASS:FAIL;

$wf_test = ($wf["company_name"]== "Wells Fargo and Company" 
	&&	$wf["company_url"]=='www.wellsfargo.com'
	&&	$wf["verification_result"]=='PASS'
	// &&	$bofa["url_matching"]=='TRUE'
)?PASS:FAIL;

$github_test = ($github["company_name"]== "Wells Fargo and Company" 
	&&	$github["company_url"]=='www.wellsfargo.com'
	&&	$github["verification_result"]=='PASS'
	// &&	$bofa["url_matching"]=='TRUE'
)?PASS:FAIL;

// TESTS
// $var_test = ()? PASS:FAIL;

$array_test=(verify_chain($good_array) == 1 && verify_chain($bad_array) != 1) ? PASS:FAIL;
$load_cert_test = ($chain_length == 1) ? PASS:$chain_length;


// OUTPUT
$txt="<!DOCTYPE html><html><head><title>VERIFICATION TESTING</title></head><body><h1>DOMAIN TESTING</h1><hr/>";
$txt=$txt."<br/>array_test: [".$array_test."]";
$txt=$txt."<br/>load_cert_test: [".$load_cert_test."]";
$txt=$txt."<br/>get_url_test: [".$get_url_test."]";
$txt=$txt."<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";
$txt=$txt."<br/>bofa_test: [".$bofa_test."]";
$txt=$txt."<br/>wf_test: [".$wf_test."]";
$txt=$txt."<br/>github_test: [".$github_test."]";
$txt=$txt."<hr/>";
$txt=$txt."<br/>output: [".$github."]";

$results_file = fopen($results_file_path, "w+") or die("Unable to open file ".$results_file_path);
fwrite($results_file, $txt);
fclose($results_file);
// var_dump(verify_domain($wf_url));
// echo "<br/>bofa: [".verify_domain($verified_json)."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";

?>

