<?php

	function verify_chain($array){
		$array=array_unique($array);
		if (count($array) == 1 && $array[0]=='good') {
			return true;
		} else {
			return false;
		};	
	};

?>