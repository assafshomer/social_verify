<?php

	$output=exec('./ocsp_1.sh https://www.google.com');
	echo "output [".$output."]\n";
?>