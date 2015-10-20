<?php

include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';

// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');
$bofa_url = 'https://www.bankofamerica.com';

// VARS
$good_array=array('good','good','good');
$bad_array=array('good','good','bad');
// $chain_length = load_certificate_chain($bofa_url);

// BANK OF AMERICA
$bofa=verify_domain($bofa_url);

// WELLS FARGO
$wf_url = 'https://www.wellsfargo.com';
$wf=verify_domain($wf_url);

// GITHUB
$github_url = 'https://github.com';
$github=verify_domain($github_url);

// TESTS
// $var_test = ()? PASS:FAIL;

$array_test=(verify_chain($good_array) == 1 && verify_chain($bad_array) != 1) ? PASS:FAIL;
// $load_cert_test = ($chain_length > 0) ? PASS:FAIL;
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

$github_test = ($github["company_name"]== "GitHub, Inc." 
	&&	$github["company_url"]=='github.com'
	&&	$github["verification_result"]=='PASS'
	// &&	$bofa["url_matching"]=='TRUE'
)?PASS:FAIL;

// OUTPUT

echo "<br/>array_test: [".$array_test."]";
// echo "<br/>load_cert_test: [".$load_cert_test."]";
echo "<br/>get_url_test: [".$get_url_test."]";
echo "<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";
echo "<br/>bofa_test: [".$bofa_test."]";
echo "<br/>wf_test: [".$wf_test."]";
echo "<br/>github_test: [".$github_test."]";
echo "<hr/>";
// echo "<br/>output: [".$github."]";
// var_dump(get_chain_verification_results(1,$github_url));
// echo "<br/>bofa: [".verify_domain($verified_json)."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";

?>

