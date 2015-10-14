<?php
$url = 'https://swarm.fund';
$contextOptions = array(
    'ssl' => array(
        'verify_peer'   => true,
        'cafile'        => '/etc/ssl/certs/ca-certificates.crt',
        'verify_depth'  => 5,
        'CN_match'      => 'swarm.fund',
        'disable_compression' => true,
        'SNI_enabled'         => true        
    )
);
$sslContext = stream_context_create($contextOptions);
$result = file_get_contents($url, NULL, $sslContext);

?>