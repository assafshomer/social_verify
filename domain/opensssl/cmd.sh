#!/bin/bash
# openssl s_client -showcerts -connect swarm.fund:443

# openssl s_client -connect blockchain.info:443

# echo QUIT | openssl s_client -connect blockchain.info:443 | sed -ne '/BEGIN CERT/,/END CERT/p'| tee ../fixtures/blockchain.txt
# FP='../fixtures/'
# CACERT=$FP'cacert.pem'
# CERT=$FP'swarm.txt'

# openssl verify -verbose -purpose sslserver -CAfile $CACERT $CERT

# $string=
STR='OCSP - URI:http://sr.symcd.com'

if [[ $STR =~ URI:(.+)$ ]]; then
    echo strresult=${BASH_REMATCH[1]}
else
    echo "unable to parse string $strname"
fi