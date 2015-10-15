#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

URL='https://bankofamerica.com';
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;
echo "Processing domain ["$DOMAIN"]";
# copy the system CA certificates file for local use
cat /etc/ssl/certs/ca-certificates.crt > CAbundle.crt;
# import the certificate chain to files level0.crt, level1.crt etc
openssl s_client -showcerts -connect \
$DOMAIN:443 -CAfile CAbundle.crt < /dev/null | \
awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
             inc {print > ("level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'

# print the servial number, subject and issuer from each certificate
for i in level?.crt; do 
	openssl x509 -noout -serial -subject -issuer -in "$i"; 
	echo; 
done

# grab Authority information access url from certificates and save to aia#.txt
for i in level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g); 
	echo "processing [$i]:"; 
	OUTPUT=$(openssl x509 -noout -text -in "$i" | grep OCSP);
	if [[ $OUTPUT =~ URI:(.+)$ ]]; then
			AIA=${BASH_REMATCH[1]};
	    echo "Authority Information Access url: ["$AIA"]";
	    echo $AIA > "aia"$I".txt";
	else
	    echo "Authority Information Access url: []"
	fi
done

# add certificate chain to the CAbundle
q='{';
for i in level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g);
	q=$q$(($I+1))','
done
q='level'${q::-1}'}.crt'
cmd='cat /etc/ssl/certs/ca-certificates.crt '$q' > CAbundle.crt'
echo $cmd
eval $cmd
# cat /etc/ssl/certs/ca-certificates.crt "$q" > CAbundle.crt

for i in level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g)	
	for j in level?.crt; do
		J=$(echo "$j" | sed -e s/[^0-9]//g)
  	if [ "$J" -eq $(($I+1)) ]; then
			echo "$i,$j"			
			AIAURL=$(cat aia$I.txt)
			echo $AIAURL
			serial=$(openssl x509 -serial -noout -in $i); 
			serial=${serial#*=};
			openssl ocsp -issuer $j -nonce -CAfile CAbundle.crt -url $AIAURL -serial "0x${serial}"
		fi		
	done
done

# cat /etc/ssl/certs/ca-certificates.crt level2.crt > CAbundle.crt
# AIAURL='http://ocsp.globalsign.com/rootr1';

# l1serial=$(openssl x509 -serial -noout -in level1.crt); l1serial=${l1serial#*=}
# openssl ocsp -issuer level2.crt -nonce -CAfile CAbundle.crt -url $AIAURL -serial "0x${l1serial}"
# cat /etc/ssl/certs/ca-certificates.crt level{1,2,3}.crt > CAbundle.crt

# l0serial=$(openssl x509 -serial -noout -in level0.crt); 
# l0serial=${l0serial#*=};
# echo "l0 serial:"$l0serial;
# openssl ocsp -issuer level1.crt -nonce -CAfile CAbundle.crt -url http://sr.symcd.com/ -serial "0x"$l0serial;