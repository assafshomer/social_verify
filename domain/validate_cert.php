<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('phpseclib/File/X509.php');
define('CA_CERT_PATH','fixtures/signer.txt');
// define('CA_CERT_PATH','fixtures/thawte.txt');
define('CERT_PATH','fixtures/google.txt');
// define('CERT_PATH','fixtures/github.txt');
define('URL','https://www.google.com');

$x509 = new File_X509();
$x509->loadCA(file_get_contents(CA_CERT_PATH));
$cert = $x509->loadX509(file_get_contents(CERT_PATH));
$sig_validate = $x509->validateSignature() ? "[valid]\n" : "[invalid]\n";
echo "signature is: ".$sig_validate;
print_r("Company: [".$x509->getDN(true)."]\n");
print_r("Issuer: [".$x509->getIssuerDN(true)."]\n");

$url_validate = $x509->validateURL(URL) ? "[valid]\n" : "[invalid]\n";
echo "url is: ".$url_validate;

?>
