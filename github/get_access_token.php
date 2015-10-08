<?php

include 'vars.php';
include SECRET_FILE;
include ROOT.'/shared/errors.php';

get_basic_auth();
get_auth();

function get_access_token(){
	$endpoint = '/authorizations/clients/'.GITHUB_CLIENT_ID;
	$formed_url = HOST.$endpoint;
	$headers = array( 
		"PUT ".$endpoint." HTTP/1.1", 
		"Host: ".HOST, 
		"User-Agent: Colu Asset Verificator"
	);	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch); 
	echo $retrievedhtml;
	return $retrievedhtml;		
};

function get_auth(){
	$endpoint = '/authorizations';
	$formed_url = HOST.$endpoint;
	$headers = array( 
		"POST ".$endpoint." HTTP/1.1", 
		"Host: ".HOST, 
		"User-Agent: Colu Asset Verificator"
	);	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$formed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, 1);
	$retrievedhtml = curl_exec ($ch);
	curl_close($ch); 
	echo $retrievedhtml;
	return $retrievedhtml;			
}

function get_basic_auth(){
	$cmd='curl -u ';
	$cmd.=GITHUB_USERNAME.':'.GITHUB_PERSONAL_TOKEN;
	$cmd.=' '.HOST.'/user';
	$output = shell_exec($cmd);		
	echo "<br/>basic oath: [".$output."]";

}

?>