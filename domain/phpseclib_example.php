<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');

include('phpseclib/File/X509.php');

$x509 = new File_X509();

// $x509->loadCA(file_get_contents('fixtures/googleCA.pem')); // see googleca.pem
// print_r($x509); 
$x509->loadX509(file_get_contents('fixtures/www.bankofamerica.com')); // see google2.pem
print_r($x509); 
echo $x509->validateSignature() ? 'valid' : 'invalid';


// $x509 = new File_X509();
// $cert = $x509->loadX509(file_get_contents('fixtures/google2.pem'));

// print_r($cert);


?>
