<?php

	class SocialVerifier {
		
		public static $prefix = 'Verifying issuance of colored coins asset with asset_id:';

		function get_pid($json,$network){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['social']['$network']['pid'];
			};
		};

		function get_uid($json){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $tmp['social']['$network']['uid'];
			};
		};

		function get_expected_text($json){
			$tmp = json_decode($json,TRUE);
			$error_message = $tmp['errors'][0]['message'];
			if (strlen($error_message)>0) {
				return $error_message;
			} else {
				return $this->pr.' ['.$tmp['social']['$network']['aid'].']';
			};
		};

	}




?>