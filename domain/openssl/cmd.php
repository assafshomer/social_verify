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

	for ($x = 0; $x < number; $x++) {
		$result=exec('./get_verification.sh '$x);
		preg_match("/0x\S+\s(\w+)\n/", $result,$matches)
	} 	
	
	
?>