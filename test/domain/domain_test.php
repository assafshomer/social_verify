<?php

include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';
define('SLOW', TRUE);
// mimicking json from eyal
$bofa_json = load_json('verified');
$wf_json = load_json('wf');
$github_json = load_json('github');
$coinbase_json = load_json('coinbase');
$colu_json = load_json('colu');
$bcinfo_json = load_json('blockchaininfo');
$colu_2nd_asset_json = load_json('colu_2nd_asset');
$colu_fake_asset_json = load_json('colu_fake_asset');

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
	&&  match_urls('cert-002.blockchain.info','www.blockchain.info')
)?PASS:FAIL;
echo "<br/>match_domains_test: [".$match_domains_test."]";

$get_domain_from_url_test = (get_domain_from_url($bofa_url) == 'www.bankofamerica.com' )?PASS:FAIL;
echo "<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";

if (SLOW=='TRUE') {
	// BANK OF AMERICA
	$bofa = verify_domain_json($bofa_json);
	$bofa_ssl_test = ($bofa["company_name"]== "Bank of America Corporation" 
		// &&	$bofa["company_url"]=='www.bankofamerica.com'
		&&	$bofa["verification_result"]=='PASS'
		&&	$bofa["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>bofa_ssl_test: [".$bofa_ssl_test."]";
	if ($bofa_ssl_test==FAIL) {var_dump($bofa);}

	// WELLS FARGO
	$wf=verify_domain_json($wf_json);
	$wf_ssl_test = ($wf["company_name"]== "Wells Fargo and Company" 
		// &&	$wf["company_url"]=='www.wellsfargo.com'
		&&	$wf["verification_result"]=='PASS'
		&&	$wf["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>wf_ssl_test: [".$wf_ssl_test."]";
	if ($wf_ssl_test==FAIL) {var_dump($wf);}

	// GITHUB
	$github=verify_domain_json($github_json);
	$github_ssl_test = ($github["company_name"]== "GitHub, Inc." 
		// &&	$github["company_url"]=='github.com'
		&&	$github["verification_result"]=='PASS'
		&&	$github["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>github_ssl_test: [".$github_ssl_test."]";
	if ($github_ssl_test==FAIL) {var_dump($github);}

	// COINBASE
	$coinbase=verify_domain_json($coinbase_json);
	$coinbase_ssl_test = ($coinbase["company_name"]== "Coinbase, Inc." 
		// &&	$coinbase["company_url"]=='www.coinbase.com'
		&&	$coinbase["verification_result"]=='PASS'
		&&	$coinbase["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>coinbase_ssl_test: [".$coinbase_ssl_test."]";
	if ($coinbase_ssl_test==FAIL) {var_dump($coinbase);}

	// COLU
	$colu=verify_domain_json($colu_json);
	$colu_ssl_test = ($colu["company_name"]== "" 
		// &&	$colu["company_url"]=='colu.co'
		&&	$colu["verification_result"]=='PASS'
		&&	$colu["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>colu_ssl_test: [".$colu_ssl_test."]";
	if ($colu_ssl_test==FAIL) {var_dump($colu);}

	// BLOCKCHAIN.INFO
	$bcinfo=verify_domain_json($bcinfo_json);
	$bcinfo_ssl_test = ($bcinfo["company_name"]== "Blockchain Luxembourg S.A.R.L" 
		&&	$bcinfo["verification_result"]=='PASS'
		&&	$bcinfo["url_matching"]=='TRUE'
	)?PASS:FAIL;
	echo "<br/>bcinfo_ssl_test: [".$bcinfo_ssl_test."]";
	if ($bcinfo_ssl_test==FAIL) {var_dump($bcinfo);}

};

echo "<hr/>";
$colu_first_asset_test = (verify_asset_json($colu_json)=='TRUE')?PASS:FAIL;
echo "<br/>colu_first_asset_test: [".$colu_first_asset_test."]";
$colu_2nd_asset_test = (verify_asset_json($colu_2nd_asset_json)=='TRUE')?PASS:FAIL;
echo "<br/>colu_2nd_asset_test: [".$colu_2nd_asset_test."]";
$colu_fake_asset_test = (verify_asset_json($colu_fake_asset_json)!='TRUE')?PASS:FAIL;
echo "<br/>colu_fake_asset_test: [".$colu_fake_asset_test."]";
// echo "<br/>output: [".$github."]";
// var_dump(get_chain_verification_results(1,$github_url));
// echo "<br/>bofa: [".var_dump(verify_domain_json($bofa_json))."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";

?>

