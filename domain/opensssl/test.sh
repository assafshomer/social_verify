#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

openssl s_client -showcerts -connect google.com:443 < /dev/null | \
awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
             inc {print > ("level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'