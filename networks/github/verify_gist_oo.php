<?php

	include '../../json_reader.php';

	class GithubVerifier {
		public static $host = 'https://api.github.com';
		public static $github_personal_token = 'ed5973263e05eb42c6ccaf550ad320583304f430';
		public static $prefix = 'Verifying issuance of colored coins asset with asset_id:';
		var $verified;

		function GithubVerifier($json){
			$this->json = $json;
			$this->reader = new JsonReader($json);
			$this->github_verify_asset($json,$this->reader);			
		}

		function github_verify_asset($json,$reader){
			$pid = $reader->get_path('social,github,pid');
			if (!$pid) {$this->verified = false;};	
			$raw_gist = $this->get_gist_with_oauth($pid);
			$gist_content = $this->parse_gist($raw_gist);
			$expected_content = $this->get_expected_text($json,$reader);
			$this->verified = ($gist_content==$expected_content);
		}

		function get_gist_with_oauth($pid){
			// limited to 5000 calls/h https://developer.github.com/v3/#rate-limiting
			$endpoint = '/gists/'.$pid;
			$formed_url = self::$host.$endpoint;
			// echo "<br/>apiurl: [".$formed_url."]";
			$headers = array( 
				"GET ".$endpoint." HTTP/1.1", 
				"Host: ".self::$host.'/gists/', 
				"User-Agent: Colu Asset Verificator",
				"Authorization: token ".self::$github_personal_token
			);	
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,$formed_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$retrievedhtml = curl_exec ($ch);
			curl_close($ch);
			// echo $retrievedhtml; 
			return $retrievedhtml;		
		}

		function parse_gist($raw_gist){
			$tmp = json_decode($raw_gist,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['files']['gistfile1.txt']['content'];
			};	
		}

		private function get_expected_text($json,$reader){
			$aid = $reader->get_path('social,github,aid');
			return self::$prefix.' ['.$aid.']';
		}



	}



?>