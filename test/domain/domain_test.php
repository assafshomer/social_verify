<?php

include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';

// mimicking json from eyal
$verified_json = load_json('verified');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');

// VARS
$good_array=array('good','good','good');
$bad_array=array('good','good','bad');
$bofa_url = 'https://www.bankofamerica.com';
$get_url_test = (get_url($verified_json)==$bofa_url)?PASS:FAIL;
$get_domain_from_url_test = (get_domain_from_url($bofa_url) == 'www.bankofamerica.com' )?PASS:FAIL;

// TESTS
// $var_test = ()? PASS:FAIL;

$array_test=(verify_chain($good_array) == 1 && verify_chain($bad_array) != 1) ? PASS:FAIL;
// $bofa_test = (github_verify_asset($verified_json) == 1) ? PASS:FAIL;


// OUTPUT

echo "<br/>array_test: [".$array_test."]";
echo "<br/>get_url_test: [".$get_url_test."]";
echo "<br/>get_domain_from_url_test: [".$get_domain_from_url_test."]";
var_dump(verify_domain($bofa_url));
// echo "<br/>bofa: [".verify_domain($verified_json)."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";

?>

