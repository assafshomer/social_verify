<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';
include SSL_ROOT.'verify_ssl_oo.php';
define('SLOW', false);
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


// echo "<hr/>";
// $df = new DomainVerifier($blank_url_json);
// echo "<br/>ssl_verified: [".$df->ssl_verified."]";
// echo "<br/>url_matching: [".$df->url_matching."]";
// echo "<br/>company_name: [".$df->company_name."]";
// echo "<br/>asset_verified: [".$df->asset_verified."]";
// if ($df->asset_verified == false) {
// 	echo 'blarg';
// }

$nothing = new DomainVerifier(null);
$null_test = ($nothing->company_name== "" 
	&&	$nothing->ssl_verified == 'FAIL'
	&&	$nothing->url_matching == false
	&&	$nothing->asset_verified == false
)?PASS:FAIL;
echo "<br/>null_test: [".$null_test."]";
if ($null_test==FAIL) {var_dump($nothing);}


?>


