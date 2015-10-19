<?php
		$embedded_url = 'https://www.bankofamerica.com';

		$certificate_chain_length = load_certificate_chain($embedded_url);
		$result_array = get_chain_verification_results($certificate_chain_length);
		$verification_result = verify_chain($result_array)?"PASS\n":"FAIL\n";
		$result = get_company_data();
		$result['verification_result']=$verification_result;
		$url_matching = ($result['company_url'] == get_domain_from_url($embedded_url))?'TRUE':'false';		
		$result['url_matching']= $url_matching;
		var_dump($result);

	function verify_domain($verification_json){
		$embedded_url = get_url($verifications_json);
		$certificate_chain_length = load_certificate_chain($embedded_url);
		$result_array = get_chain_verification_results($certificate_chain_length);
		$verification_result = verify_chain($result_array)?"PASS\n":"FAIL\n";
		$result = get_company_data();
		$result['verification_result']=$verification_result;
		$url_matching = ($result['company_url'] == get_domain_from_url($embedded_url))?'TRUE':'false';		
		$result['url_matching']= $url_matching;
		return $result;
	};


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

	function get_company_data(){
		$subject=exec('./get_company_data.sh');
		preg_match("/O=(.+)\//U",$subject,$matches);
		$company_name=$matches[1];
		preg_match("/CN=(.+)/",$subject,$matches);
		$company_url=$matches[1];
		$data = ['company_name' => $company_name,
						'company_url' => $company_url,];
		return $data;
	};

	function load_certificate_chain($url){
		return exec('./ocsp_load.sh '.$url);
	};

	function get_url($json){
		$tmp = json_decode($json,TRUE);
		$error_message = $tmp['errors'][0]['message'];
		if (strlen($error_message)>0) {
			return $error_message;
		} else {
			return $tmp['domain']['url'];
		};
	};

	function get_domain_from_url($url){
		preg_match("/https:\/\/(.+)/", $url,$matches);
		return $matches[1];
	}
	
?>