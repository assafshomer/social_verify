<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
include '../test_helper.php';
include APP_ROOT.'twitter/verify_tweet.php';

$verified_json = load_json('verified_2');
$unverified_json = load_json('unverified');
$fake_networks_json = load_json('fake_networks');


$get_tweet_by_id_test = (get_tweet(651645990554968064) == 'Verifying issuance of colored coins asset with asset_id: [LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX]')?PASS:FAIL;

$verified_test = (twitter_verify_asset($verified_json) == 1) ? PASS:FAIL;
$unverified_test = (twitter_verify_asset($unverified_json) <> 1) ? PASS:FAIL;
$fake_networks_test = (twitter_verify_asset($fake_networks_json) <> 1) ? PASS:FAIL;

echo "get_tweet_by_id_test: [".$get_tweet_by_id_test."]<br/>";

echo "<hr/>";

echo "verified_test: [".$verified_test."]<br/>";
echo "unverified_test: [".$unverified_test.']<br/>';
echo "fake_networks_test: [".$fake_networks_test.']<br/>';

echo "<hr/>";

// echo "get_tweet_from_query: [".get_tweet_from_query('?q=%23test').']<br/>';

?>