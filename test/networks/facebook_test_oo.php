<?php
include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include APP_ROOT.'facebook/verify_post_oo.php';
// include APP_ROOT.'facebook/get_access_token.php';
// mimicking json from eyal
$verified_json = load_json('verified');


$verified = new FacebookVerifier($verified_json);
$verified_test = ($verified->verified) ? PASS:FAIL;


echo "<br/>verified_test: [".$verified_test."]";

echo "<hr/>";

?>
