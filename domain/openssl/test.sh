#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

openssl s_client -showcerts -connect coinbase.com:443 -CAfile CAbundle.crt < /dev/null | \
awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
             inc {print > ("level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'
for i in level?.crt; do openssl x509 -noout -serial -subject -issuer -in "$i"; echo; done
for i in level?.crt; do echo "$i:"; openssl x509 -noout -text -in "$i" | grep OCSP; done
cat /etc/ssl/certs/ca-certificates.crt level{1,2}.crt > CAbundle.crt;

l0serial=$(openssl x509 -serial -noout -in level0.crt); l0serial=${l0serial#*=}
openssl ocsp -issuer level1.crt -nonce -CAfile CAbundle.crt -url http://ocsp.digicert.com/ -serial "0x${l0serial}"

l1serial=$(openssl x509 -serial -noout -in level1.crt); l1serial=${l1serial#*=}
openssl ocsp -issuer level2.crt -nonce -CAfile CAbundle.crt -url http://ocsp.digicert.com/ -serial "0x${l1serial}"