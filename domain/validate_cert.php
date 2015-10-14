<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('phpseclib/File/X509.php');
define('CERT_PATH','fixtures/google.txt');
// define('CERT_PATH','fixtures/github.com');


$x509 = new File_X509();
$x509->loadCA(file_get_contents('fixtures/signer.txt'));
$cert = $x509->loadX509(file_get_contents(CERT_PATH));
echo $x509->validateSignature() ? 'valid' : 'invalid';
?>
