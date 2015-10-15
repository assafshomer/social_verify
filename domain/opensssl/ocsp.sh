#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

# openssl s_client -showcerts -connect bankofamerica.com:443 < /dev/null | \
# awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
#              inc {print > ("level" c ".crt")}
#              /---END CERTIFICATE-----/{inc=0}'

# for i in level?.crt; do openssl x509 -noout -serial -subject -issuer -in "$i"; echo; done

# for i in level?.crt; do echo "$i:"; openssl x509 -noout -text -in "$i" | grep OCSP; done

for i in level?.crt; do 
	echo "processing [$i]:"; 
	OUTPUT=$(openssl x509 -noout -text -in "$i" | grep OCSP);
	if [[ $OUTPUT =~ URI:(.+)$ ]]; then
	    echo "Authority Information Access url: ["${BASH_REMATCH[1]}"]"
	else
	    echo "Authority Information Access url: []"
	fi
done




# for i in level?.crt; do echo "$i" > max.txt; done

# for i in level?.crt; do
# 	I=$(echo "$i" | sed -e s/[^0-9]//g)	
# 	for j in level?.crt; do
# 		J=$(echo "$j" | sed -e s/[^0-9]//g)
#   	if [ "$J" -eq $(($I+1)) ]; then
# 			echo "$i,$j"			
# 		fi		
# 	done
# done

# for i in level?.crt; do
# 	I=$(echo "$i" | sed -e s/[^0-9]//g)	
# 	for j in level?.crt; do
# 		J=$(echo "$j" | sed -e s/[^0-9]//g)
#   	if [ "$J" -eq $(($I+1)) ]; then
# 			echo "$i,$j"			
# 		fi		
# 	done
# done


# cat /etc/ssl/certs/ca-certificates.crt level2.crt > CAbundle.crt

# l1serial=$(openssl x509 -serial -noout -in level1.crt); l1serial=${l1serial#*=}
# openssl ocsp -issuer level2.crt -nonce -CAfile CAbundle.crt -url http://sr.symcd.com/ -serial "0x${l1serial}"
