<?php	
	class DomainVerifier {

		public static $cdir = '/tmp/verify/certs';
		public static $certFileName = 'level';
		public static $negativeResult = array('company_name'=>'','company_url'=>'','verification_result'=>false,'url_matching'=>false);

		function DomainVerifier($json){
			$this->json = $json;
			$result = $this->verify_domain_json($json);
			$this->company_name=$result['company_name'];
			$this->company_url=$result['company_url'];
			$this->url_matching=$result['url_matching'];
			$this->ssl_verified=$result['verification_result'];			
			$this->asset_verified=$this->verify_asset_json($json);
		}

		private function verify_domain_json($json){
			if (empty($json)) {
				return self::$negativeResult;
			};			
			$url = get_url($json);		
			if (verify_url($url)) {
				return verify_domain_by_url($url);
			} else {
				return self::$negativeResult;
			};
		}

		private function verify_url($url){
			$pattern = "/https:\/\/(\w*\.+)+/i";
			return preg_match($pattern, $url) ? TRUE : false;
		}

		private function verify_domain_by_url($url){
			// echo "<br/>$url: [".$url."]";
			$certificate_chain_length = load_certificate_chain($url);
			$result_array = get_chain_verification_results($certificate_chain_length,$url);
			$verification_result = verify_chain($result_array)?TRUE:false;
			$result = get_company_data($url);
			$result['verification_result']=$verification_result;
			$url_matching = match_urls(get_domain_from_url($url),$result['company_url']);		
			$result['url_matching']= $url_matching;
			// unset($result['company_url']); # we don't need it anymore after matching
			return $result;
		}

		private function match_urls($url1,$url2){
			$s1=truncate_first($url1);
			$s2=truncate_first($url2);
			return ($s1==$s2 || $s2==$url1 || $s1==$url2)?TRUE:false;
		}

		private function truncate_first($url){
			$tmp=explode('.',$url);
			array_shift($tmp);
			return implode(".", $tmp);
		}

		private function verify_chain($array){
			$array=array_unique($array);
			if (count($array) == 1 && $array[0]=='good') {
				return true;
			} else {
				return false;
			};	
		}

		private function get_chain_verification_results($chain_length,$url){		
			$result_array = array();
			$tag = str_replace('.', '_', get_domain_from_url($url));	
			for ($x = 0; $x < $chain_length; $x++) {		
				$result=file_get_contents(CDIR.$tag.'_result'.$x.'.txt');
				preg_match("/0x\S+\s(\w+)\n/", $result,$matches);
				array_push($result_array,$matches[1]);
			}
			return $result_array;
		}

		private function get_company_data($url){
			chdir(dirname(__FILE__));
			$cmd = './get_company_data.sh '.$url.' '.CDIR.' '.CERT_FILE_NAME;
			$subject=exec($cmd);
			preg_match("/O=(.+)\//U",$subject,$matches);
			$company_name=$matches[1];
			preg_match("/CN=(.+)/",$subject,$matches);
			$company_url=$matches[1];
			$data = ['company_name' => $company_name,
							'company_url' => $company_url,];
			return $data;
		}

		private function load_certificate_chain($url){
			chdir(dirname(__FILE__));
			$cmd = './ocsp_load.sh '.$url.' '.CDIR.' '.CERT_FILE_NAME;
			// echo $cmd;
			return exec($cmd);
		}

		private function get_url($json){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['domain']['url'];
			};
		}

		private function get_file_path($json){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['domain']['path'];
			};
		}

		private function get_asset_id($json){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['domain']['aid'];
			};
		}

		private function get_domain_from_url($url){
			preg_match("/https:\/\/(.+)/", $url,$matches);
			return $matches[1];
		}

		private function verify_asset_json($json){
			if (empty($json)) {return false;};			
			$path = get_file_path($json);
			if (empty($path)) {return false;};
			$url = get_url($json);
			if (empty($url)) {return false;};
			$aid = get_asset_id($json);
			if (empty($aid)) {return false;};
			$file = file_get_contents($url.'/'.$path);
			$regex="/^$aid\n|\n$aid\n|\n$aid$/";
			preg_match($regex,$file,$matches);
			// return (trim($matches[0]) == $aid)?TRUE:var_dump($matches);	#for debu	
			return (trim($matches[0]) == $aid)?TRUE:false;	
		}

	}


	

?>
