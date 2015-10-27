<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
// include SSL_ROOT.'verify_ssl.php';
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



$get_url_test = (get_url($bofa_json)==$bofa_url)?PASS:get_url($bofa_json);
echo "<br/>get_url_test: [".$get_url_test."]";

// echo "<hr/>";
// $df = new DomainVerifier($blank_url_json);
// echo "<br/>ssl_verified: [".$df->ssl_verified."]";
// echo "<br/>url_matching: [".$df->url_matching."]";
// echo "<br/>company_name: [".$df->company_name."]";
// echo "<br/>asset_verified: [".$df->asset_verified."]";
// if ($df->asset_verified == false) {
// 	echo 'blarg';
// }

// $bofa = new DomainVerifier($bofa_json);
// $bofa_ssl_test = ($bofa->company_name  == "Bank of America Corporation" 
// 	&&	$bofa->ssl_verified == TRUE
// 	&&	$bofa->url_matching == TRUE
// 	&&	$bofa->asset_verified == false
// )?PASS:FAIL;
// echo "<br/>bofa_ssl_test: [".$bofa_ssl_test."]";
// if ($bofa_ssl_test==FAIL) {var_dump($bofa);}


?>


