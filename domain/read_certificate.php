<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('phpseclib/File/X509.php');


// define('CERT_PATH','fixtures/google.txt');
define('CERT_PATH','fixtures/DigiCertSHA2ExtendedValidationServerCA.crt');
// define('CERT_PATH','fixtures/.txt');


$x509 = new File_X509();

$x509->loadX509(file_get_contents(CERT_PATH));
print_r($x509->getDNProp('CN'));
// print_r($x509->getDN());
print_r("Company: [".$x509->getDN(true)."]\n");
print_r("Issuer: [".$x509->getIssuerDN(true)."]\n");
print_r("PubKey: [\n".$x509->getPublicKey()."\n]\n");
echo $x509->validateSignature() ? "[valid]\n" : "[invalid]\n";

?>

