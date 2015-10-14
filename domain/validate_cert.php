<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('phpseclib/File/X509.php');

// GOOGLE
// define('CA_CERT_PATH','fixtures/signer.txt');
// define('CERT_PATH','fixtures/google.txt');
// define('URL','https://www.google.com/');

// GITHUB
// define('CA_CERT_PATH','fixtures/DigiCertSHA2ExtendedValidationServerCA.crt');
// define('CERT_PATH','fixtures/github.com');
// define('URL','https://github.com');

// BofA
// define('CA_CERT_PATH','fixtures/symantec.crt');
// define('CERT_PATH','fixtures/www.bankofamerica.com');
// define('URL','https://www.bankofamerica.com/');

// unix
// define('CA_CERT_PATH','/etc/ssl/certs/ca-certificates.crt');

// http://anduin.linuxfromscratch.org/BLFS/other/certdata.txt
define('CA_CERT_PATH','fixtures/cacert.pem');

define('CERT_PATH','fixtures/swarm.txt');
// define('URL','https://www.bankofamerica.com/');

$x509 = new File_X509();
$x509->loadCA(file_get_contents(CA_CERT_PATH));
$cert = $x509->loadX509(file_get_contents(CERT_PATH));
$sig_validate = $x509->validateSignature() ? "[valid]\n" : "[invalid]\n";
echo "signature is: ".$sig_validate;
print_r("Company: [".$x509->getDN(true)."]\n");
print_r("Issuer: [".$x509->getIssuerDN(true)."]\n");

// print_r($x509->validateURL(URL));
$url_validate = $x509->validateURL(URL) ? "[valid]\n" : "[invalid]\n";
echo "url is: ".$url_validate;

?>
