<?php

include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';
define('SLOW', true);
// mimicking json from eyal
$bofa_json = load_json('verified');
$wf_json = load_json('wf');
$github_json = load_json('github');
$coinbase_json = load_json('coinbase');
$colu_json = load_json('colu');
$bcinfo_json = load_json('blockchaininfo');

// VARS
$good_array=array('good','good','good');
$bad_array=array('good','good','bad');
$bofa_url = 'https://www.bankofamerica.com';

// TESTS
// $var_test = ()? PASS:FAIL;

$array_test=(verify_chain($good_array) == 1 && verify_chain($bad_array) != 1) ? PASS:FAIL;
echo "<br/>array_test: [".$array_test."]";

$get_url_test = (get_url($bofa_json)==$bofa_url)?PASS:get_url($bofa_json);
echo "<br/>get_url_test: [".$get_url_test."]";

$match_domains_test=(match_urls('www.foo.bar','xxx.foo.bar')
	&&  match_urls('www.foo.bar','*.foo.bar')
	&&  match_urls('foo.bar','*.foo.bar')
	&&  match_urls('foo.bar','www.foo.bar')
)?PASS:FAIL;
echo "<br/>match_domains_test: [".$match_domains_test."]";

$get_domain_from_url_test = (get_domain_from_url($bofa_url) == 'www.bankofamerica.com' )?PASS:FAIL;
echo "<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";

if (SLOW=='TRUE') {
	// BANK OF AMERICA
	$bofa = verify_domain_json($bofa_json);
	$bofa_test = ($bofa["company_name"]== "Bank of America Corporation" 
		&&	$bofa["company_url"]=='www.bankofamerica.com'
		&&	$bofa["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>bofa_test: [".$bofa_test."]";
	if ($bofa_test==FAIL) {var_dump($bofa);}

	// WELLS FARGO
	$wf=verify_domain_json($wf_json);
	$wf_test = ($wf["company_name"]== "Wells Fargo and Company" 
		&&	$wf["company_url"]=='www.wellsfargo.com'
		&&	$wf["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>wf_test: [".$wf_test."]";
	if ($wf_test==FAIL) {var_dump($wf);}

	// GITHUB
	$github=verify_domain_json($github_json);
	$github_test = ($github["company_name"]== "GitHub, Inc." 
		&&	$github["company_url"]=='github.com'
		&&	$github["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>github_test: [".$github_test."]";
	if ($github_test==FAIL) {var_dump($github);}

	// COINBASE
	$coinbase=verify_domain_json($coinbase_json);
	$coinbase_test = ($coinbase["company_name"]== "Coinbase, Inc." 
		&&	$coinbase["company_url"]=='www.coinbase.com'
		&&	$coinbase["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>coinbase_test: [".$coinbase_test."]";
	if ($coinbase_test==FAIL) {var_dump($coinbase);}

	// COLU
	$colu=verify_domain_json($colu_json);
	$colu_test = ($colu["company_name"]== "" 
		&&	$colu["company_url"]=='colu.co'
		&&	$colu["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>colu_test: [".$colu_test."]";
	if ($colu_test==FAIL) {var_dump($colu);}

	// BLOCKCHAIN.INFO
	$bcinfo=verify_domain_json($bcinfo_json);
	$bcinfo_test = ($bcinfo["company_name"]== "Blockchain Luxembourg S.A.R.L" 
		&&	$bcinfo["company_url"]=='www.blockchain.info'
		&&	$bcinfo["verification_result"]=='PASS'
		// &&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>bcinfo_test: [".$bcinfo_test."]";
	if ($bcinfo_test==FAIL) {var_dump($bcinfo);}




};


echo "<hr/>";
// echo "<br/>output: [".$github."]";
// var_dump(get_chain_verification_results(1,$github_url));
// echo "<br/>bofa: [".verify_domain($bofa_json)."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";

?>

