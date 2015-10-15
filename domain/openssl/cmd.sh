#!/bin/bash
# openssl s_client -showcerts -connect swarm.fund:443

# openssl s_client -connect blockchain.info:443

# echo QUIT | openssl s_client -connect blockchain.info:443 | sed -ne '/BEGIN CERT/,/END CERT/p'| tee ../fixtures/blockchain.txt
# FP='../fixtures/'
# CACERT=$FP'cacert.pem'
# CERT=$FP'swarm.txt'

# openssl verify -verbose -purpose sslserver -CAfile $CACERT $CERT

# # $string=
# STR='OCSP - URI:http://sr.symcd.com'

# if [[ $STR =~ URI:(.+)$ ]]; then
#     FOO=${BASH_REMATCH[1]};
#     echo $FOO > 'blarg.txt';
# else
#     echo "unable to parse string $strname"
# fi

# for i in level?.crt; do
# 	I=$(echo "$i" | sed -e s/[^0-9]//g)	
# 	for j in level?.crt; do
# 		J=$(echo "$j" | sed -e s/[^0-9]//g)
#   	if [ "$J" -eq $(($I+1)) ]; then
# 			echo "$i,$j"			
# 		fi
# 	done
# 	if [[ "$I" -eq "$J" ]]; then
# 		echo "max is "$j
# 	fi
# done

# q='{';
# for i in level?.crt; do
# 	I=$(echo "$i" | sed -e s/[^0-9]//g);
# 	q=$q$(($I+1))','
# done
# q='level'${q::-3}'}.crt'
# cmd='cat /etc/ssl/certs/ca-certificates.crt '$q' > CAbundle.crt'
# echo $cmd

# foo=1
# declare "magic_variable_$foo"=2
# echo $magic_variable_1

printf "foo\nbar"