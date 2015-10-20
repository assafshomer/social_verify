<?php	

	// $embedded_url = 'https://github.com';
	// $result = verify_domain($embedded_url);
	// var_dump($result);

	function verify_domain_json($json){
		$url = get_url($json);
		return verify_domain_by_url($url);
	}

	function verify_domain_by_url($url){
		$certificate_chain_length = load_certificate_chain($url);
		$result_array = get_chain_verification_results($certificate_chain_length,$url);
		$verification_result = verify_chain($result_array)?"PASS":"FAIL";
		$result = get_company_data($url);
		$result['verification_result']=$verification_result;
		$url_matching = match_urls(get_domain_from_url($url),$result['company_url']);		
		$result['url_matching']= $url_matching;
		return $result;
	};

	function match_urls($url1,$url2){
		$s1=truncate_first($url1);
		$s2=truncate_first($url2);
		return ($s1==$s2 || $s2==$url1)?TRUE:false;
	};

	function truncate_first($url){
		$tmp=explode('.',$url);
		array_shift($tmp);
		return implode(".", $tmp);
	}

	function verify_chain($array){
		$array=array_unique($array);
		if (count($array) == 1 && $array[0]=='good') {
			return true;
		} else {
			return false;
		};	
	};

	function get_chain_verification_results($chain_length,$url){
		$result_array = array();
		$tag = str_replace('.', '_', get_domain_from_url($url));	
		for ($x = 0; $x < $chain_length; $x++) {		
			$result=file_get_contents('tmp/'.$tag.'_result'.$x.'.txt');
			preg_match("/0x\S+\s(\w+)\n/", $result,$matches);
			array_push($result_array,$matches[1]);
		}
		return $result_array;
	};

	function get_company_data($url){
		chdir(dirname(__FILE__));
		$cmd = './get_company_data.sh '.$url;
		$subject=exec($cmd);
		preg_match("/O=(.+)\//U",$subject,$matches);
		$company_name=$matches[1];
		preg_match("/CN=(.+)/",$subject,$matches);
		$company_url=$matches[1];
		$data = ['company_name' => $company_name,
						'company_url' => $company_url,];
		return $data;
	};

	function load_certificate_chain($url){
		chdir(dirname(__FILE__));
		$cmd = './ocsp_load.sh '.$url;
		// echo $cmd;
		return exec($cmd);
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