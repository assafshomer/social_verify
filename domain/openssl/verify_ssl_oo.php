<?php	
	class DomainVerifier {

		public static $cdir = 'tmp/';
		public static $certFileName = 'level';
		public static $negativeResult = array('company_name'=>'','company_url'=>'','verification_result'=>false,'url_matching'=>false);

		function DomainVerifier($json){
			$this->json = $json;
			$this->verify_domain_json($json);
			$this->verify_asset_json($json);
		}

		private function verify_domain_json($json){
			if (empty($json)) {
				return self::$negativeResult;
			};			
			$url = $this->get_url($json);		
			if ($this->verify_url($url)) {
				return $this->verify_domain_by_url($url);
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
			$certificate_chain_length = $this->load_certificate_chain($url);
			$result_array = $this->get_chain_verification_results($certificate_chain_length,$url);
			$verification_result = $this->verify_chain($result_array)?TRUE:false;
			$result = $this->get_company_data($url);
			$this->ssl_verified=$verification_result;
			$url_matching = $this->match_urls($this->get_domain_from_url($url),$this->company_url);		
			// $result['url_matching']= $url_matching;
			$this->url_matching = $url_matching;
			// unset($result['company_url']); # we don't need it anymore after matching
			return $result;
		}

		private function match_urls($url1,$url2){
			$s1=$this->truncate_first($url1);
			$s2=$this->truncate_first($url2);
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
			$tag = str_replace('.', '_', $this->get_domain_from_url($url));	
			for ($x = 0; $x < $chain_length; $x++) {		
				$result=file_get_contents(self::$cdir.$tag.'_result'.$x.'.txt');
				preg_match("/0x\S+\s(\w+)\n/", $result,$matches);
				array_push($result_array,$matches[1]);
			}
			return $result_array;
		}

		private function get_company_data($url){
			chdir(dirname(__FILE__));
			$cmd = './get_company_data.sh '.$url.' '.self::$cdir.' '.self::$certFileName;
			$subject=exec($cmd);
			preg_match("/O=(.+)\//U",$subject,$matches);
			$this->company_name=$matches[1];
			preg_match("/CN=(.+)/",$subject,$matches);
			$this->company_url=$matches[1];
		}

		private function load_certificate_chain($url){
			chdir(dirname(__FILE__));
			$cmd = './ocsp_load.sh '.$url.' '.self::$cdir.' '.self::$certFileName;
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
			$path = $this->get_file_path($json);
			if (empty($path)) {return false;};
			$url = $this->get_url($json);
			if (empty($url)) {return false;};
			$aid = $this->get_asset_id($json);
			if (empty($aid)) {return false;};
			$file = file_get_contents($url.'/'.$path);
			$regex="/^$aid\n|\n$aid\n|\n$aid$/";
			preg_match($regex,$file,$matches);
			// return (trim($matches[0]) == $aid)?TRUE:var_dump($matches);	#for debu	
			$this->asset_verified = (trim($matches[0]) == $aid);
		}

	}


	

?>
