<?php
	define('PREFIX','Verifying issuance of colored coins asset with asset_id:');
	
	function debug(){
		$path = $_SERVER['DOCUMENT_ROOT'].'/verify/shared/debug';
		$file = fopen($path, "r") or die("Unable to open file! [".$path."]");
		$debug = fread($file,filesize($path));
		fclose($file);
		if ($debug=='TRUE') {
			include $_SERVER['DOCUMENT_ROOT'].'/verify/shared/errors.php';
		};
	};

	debug();	
?>