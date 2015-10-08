<?php
// include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
// echo "foo</br>";
// // for($i = 0; $i < 10; $i++) {
// // 	echo $i . "</br>";
// // }
// $path = 'scratchpad.json';
// $jsonfile = fopen($path, "a+") or die("Unable to open file!");
// $size = filesize($path);
// $json = fread($jsonfile,$size);
// echo "<br/>".$json;
// echo "<br/>".json_decode($json,TRUE)['token_type'];
// echo "<br/>".json_decode($json,TRUE);

// echo "<br/>".$_SERVER['DOCUMENT_ROOT'];

echo "foo";

$cars = array("Volvo", "BMW", "Toyota");
echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";


$params = array( 
  'grant_type'=>'fb_exchange_token',          
  'client_id'=>'foo',
  'client_secret'=>'bar',
  'fb_exchange_token'=>'buzz'
);
$formed_url =  http_build_query($params);
echo "<br/> formed_url: [".$formed_url.']';

if (preg_match("/php/i", "PHP is the web scripting language of choice.")) {
    echo "A match was found.";
} else {
    echo "A match was not found.";
}

$foo='a';
$foo.='b';
echo $foo;


// $output = shell_exec('ls -lart');
// echo "<pre>$output</pre>";
?>