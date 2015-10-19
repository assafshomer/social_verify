<?php
	$url = 'https://www.bankofamerica.com';
	$output=exec('./ocsp_1.sh '.$url);
	echo "output [".$output."]\n";
?>