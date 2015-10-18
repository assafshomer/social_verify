<?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://verifier.login.persona.org/verify");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, '/etc/pki/tls/cacert.pem');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $response = curl_exec($ch);
        print($response);
        print(curl_error($ch));
?>