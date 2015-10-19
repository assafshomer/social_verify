<?php
	$url = 'https://www.coinbase.com';
	$number=exec('./ocsp_1.sh '.$url);
	echo "number [".$number."]\n";
	$issuer=exec('./get_company.sh');
	$output=preg_match("/O=(.+)\//U",$issuer,$matches);
	echo "output [".$matches[1]."]\n";
?>