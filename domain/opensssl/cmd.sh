#!/bin/bash
# openssl s_client -showcerts -connect swarm.fund:443

openssl s_client -connect blockchain.info:443

# echo QUIT | openssl s_client -connect blockchain.info:443 | sed -ne '/BEGIN CERT/,/END CERT/p'| tee ../fixtures/blockchain.txt
FP='../fixtures/'
CACERT=$FP'cacert.pem'
CERT=$FP'swarm.txt'

# openssl verify -verbose -purpose sslserver -CAfile $CACERT $CERT

OCSP - URI:http://sr.symcd.com
${BASH_REMATCH[1]}