<?php
	$url = 'https://www.bankofamerica.com';
	$number=exec('./ocsp_load.sh '.$url);
	$length = $number+1;
	echo "Certificate chain is of length [".$length."]\n";
	$subject=exec('./get_company_data.sh');
	preg_match("/O=(.+)\//U",$subject,$matches);
	echo "company name [".$matches[1]."]\n";
	preg_match("/CN=(.+)/",$subject,$matches);
	echo "company URL [".$matches[1]."]\n";


	$result_array = get_chain_verification_results($number);
	$verification_result = verify_chain($result_array)?"PASS\n":"FAIL\n";
	echo "verification result:".$verification_result;

	function verify_chain($array){
		$array=array_unique($array);
		if (count($array) == 1 && $array[0]=='good') {
			return true;
		} else {
			return false;
		};	
	};

	function get_chain_verification_results($chain_length){
		$result_array = array();	
		for ($x = 0; $x < $chain_length; $x++) {		
			$result=file_get_contents('tmp/result'.$x.'.txt');
			preg_match("/0x\S+\s(\w+)\n/", $result,$matches);
			array_push($result_array,$matches[1]);
		}
		return $result_array;
	};
	
?>