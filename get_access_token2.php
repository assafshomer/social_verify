<?php
require_once __DIR__ . '/vendor/autoload.php';
use Facebook\Entities\AccessToken;
use Facebook\FacebookSDKException;
echo "foo";
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
$accessToken = new AccessToken('CAACEdEose0cBAIBadi5vxVJ6oaNZAgqnuiIQqB8LbMJlZBJp61ukMlS77A5uNG2FROYKMtLhflOCMTT7XedshPmm4j4O085ltsZCOGTxlCXbxNRee0aLsZCsGWc6LNANAhz0AtZBKaIDm9DLYIQ58nrGm1zfJU2Dscf82uTCnJIBK3e191ixosZBFpend5mx48oYzTe5ftGQZDZD');
echo "bar";
try {
  // Get info about the token
  // Returns a GraphSessionInfo object
  $accessTokenInfo = $accessToken->getInfo();
} catch(FacebookSDKException $e) {
  echo 'Error getting access token info: ' . $e->getMessage();
  exit;
}
echo "doo";
// Dump the info about the token
echo $accessTokenInfo;
?>