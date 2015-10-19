<?php

include '../test_helper.php';
include SSL_ROOT.'verify_ssl.php';

// VARS
$good_array=array('good','good','good');
$bad_array=array('good','good','bad');
$bofa_url = 'https://www.bankofamerica.com';

// TESTS
// $var_test = ()? PASS:FAIL;
$array_test=(verify_chain($good_array) == 1 && verify_chain($bad_array) != 1) ? PASS:FAIL;
// $bofa_test = (github_verify_asset($verified_json) == 1) ? PASS:FAIL;



// OUTPUT

echo "<br/>array_test: [".$array_test."]";

// AUX OUTPUTS
// echo "<br/>gist: [".$gist."]";


$print_error=($error_test==FAIL)?"<br/>error: [".$er."]":'';
echo $print_error;
?>

