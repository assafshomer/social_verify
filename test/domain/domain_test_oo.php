<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include SSL_ROOT.'verify_ssl_oo.php';
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
$blank_url_json = load_json('blank_url');
$fake_url_json = load_json('fake_url');

$nothing = new DomainVerifier(null);
$null_test = ($nothing->company_name== "" 
	&&	$nothing->ssl_verified == false
	&&	$nothing->url_matching == false
	&&	$nothing->asset_verified == false
)?PASS:FAIL;
echo "<br/>null_test: [".$null_test."]";
if ($null_test==FAIL) {var_dump($nothing);}

$blank = new DomainVerifier('');
$blank_test = ($blank->company_name== "" 
	&&	$blank->ssl_verified == false
	&&	$blank->url_matching == false
	&&	$blank->asset_verified == false
)?PASS:FAIL;
echo "<br/>blank_test: [".$blank_test."]";
if ($blank_test==FAIL) {var_dump($blank);}

$empty = new DomainVerifier(' ');
$empty_test = ($empty->company_name== "" 
	&&	$empty->ssl_verified == false
	&&	$empty->url_matching == false
	&&	$empty->asset_verified == false
)?PASS:FAIL;
echo "<br/>empty_test: [".$empty_test."]";
if ($empty_test==FAIL) {var_dump($empty);}

$nonjson = new DomainVerifier('blarg');
$nonjson_test = ($nonjson->company_name== "" 
	&&	$nonjson->ssl_verified == false
	&&	$nonjson->url_matching == false
	&&	$nonjson->asset_verified == false
)?PASS:FAIL;
echo "<br/>nonjson_test: [".$nonjson_test."]";
if ($nonjson_test==FAIL) {var_dump($nonjson);}

$blankurl = new DomainVerifier($blank_url_json);
$blankurl_test = ($blankurl->company_name== "" 
	&&	$blankurl->ssl_verified == false
	&&	$blankurl->url_matching == false
	&&	$blankurl->asset_verified == false
)?PASS:FAIL;
echo "<br/>blankurl_test: [".$blankurl_test."]";
if ($blankurl_test==FAIL) {var_dump($blankurl);}

$fakeurl = new DomainVerifier($fake_url_json);
$fakeurl_test = ($fakeurl->company_name== "" 
	&&	$fakeurl->ssl_verified == false
	&&	$fakeurl->url_matching == false
	&&	$fakeurl->asset_verified == false
)?PASS:FAIL;
echo "<br/>fakeurl_test: [".$fakeurl_test."]";
if ($fakeurl_test==FAIL) {var_dump($fakeurl);}

// BANK OF AMERICA
$bofa = new DomainVerifier($bofa_json);
$bofa_ssl_test = ($bofa->company_name  == "Bank of America Corporation" 
	&&	$bofa->ssl_verified == TRUE
	&&	$bofa->url_matching == TRUE
	&&	$bofa->asset_verified == false
)?PASS:FAIL;
echo "<br/>bofa_ssl_test: [".$bofa_ssl_test."]";
if ($bofa_ssl_test==FAIL) {var_dump($bofa);}

if (SLOW=='TRUE') {

	// WELLS FARGO
	$wf=new DomainVerifier($wf_json);
	$wf_ssl_test = ($wf->company_name == "Wells Fargo and Company" 
		// &&	$wf["company_url"]=='www.wellsfargo.com'
		&&	$wf->ssl_verified == TRUE
		&&	$wf->url_matching == TRUE
		&&	$wf->asset_verified == false
	)?PASS:FAIL;
	echo "<br/>wf_ssl_test: [".$wf_ssl_test."]";
	if ($wf_ssl_test==FAIL) {var_dump($wf);}

	// GITHUB
	$github=new DomainVerifier($github_json);
	$github_ssl_test = ($github->company_name == "GitHub, Inc." 
		// &&	$github["company_url"]=='github.com'
		&&	$github->ssl_verified == TRUE
		&&	$github->url_matching == TRUE
		&&	$github->asset_verified == false
	)?PASS:FAIL;
	echo "<br/>github_ssl_test: [".$github_ssl_test."]";
	if ($github_ssl_test==FAIL) {var_dump($github);}

	// COINBASE
	$coinbase=new DomainVerifier($coinbase_json);
	$coinbase_ssl_test = ($coinbase->company_name == "Coinbase, Inc." 
		// &&	$coinbase["company_url"]=='www.coinbase.com'
		&&	$coinbase->ssl_verified == TRUE
		&&	$coinbase->url_matching == TRUE
		&&	$coinbase->asset_verified == false
	)?PASS:FAIL;
	echo "<br/>coinbase_ssl_test: [".$coinbase_ssl_test."]";
	if ($coinbase_ssl_test==FAIL) {var_dump($coinbase);}

	// COLU
	$colu=new DomainVerifier($colu_json);
	$colu_ssl_test = ($colu->company_name == "" 
		// &&	$colu["company_url"]=='colu.co'
		&&	$colu->ssl_verified == TRUE
		&&	$colu->url_matching == TRUE
		&&	$colu->asset_verified == TRUE
	)?PASS:FAIL;
	echo "<br/>colu_ssl_test: [".$colu_ssl_test."]";
	if ($colu_ssl_test==FAIL) {var_dump($colu);}

	// BLOCKCHAIN.INFO
	$bcinfo=new DomainVerifier($bcinfo_json);
	$bcinfo_ssl_test = ($bcinfo->company_name == "Blockchain Luxembourg S.A.R.L" 
		&&	$bcinfo->ssl_verified == TRUE
		&&	$bcinfo->url_matching == TRUE
		&&	$bcinfo->asset_verified == false
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


