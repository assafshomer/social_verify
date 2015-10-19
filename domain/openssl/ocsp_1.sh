#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

# extract domain from url
URL=$1;
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;

# change to current dir
cd ${0%/*};

# remove auxiliary files
rm -f tmp/aia*.txt;
rm -f tmp/level*.crt;

# define the name of the certificates file
CAF='CAbundle.crt';
MB='https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt';

# copy the system CA certificates file for local use
cat /etc/ssl/certs/ca-certificates.crt > $CAF;

# add Automatically converted CA Certs from mozilla.org from  https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
wget -q -O mozbunle.crt $MB;
cat mozbunle.crt >> $CAF;

# import the certificate chain to files level0.crt, level1.crt etc
openssl s_client -showcerts -connect \
$DOMAIN:443 -CAfile $CAF < /dev/null | \
awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
             inc {print > ("tmp/level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'

# grab Authority information access url from certificates and save to aia#.txt
printf "Authority Information Access urls\n****************************************\n"
for i in tmp/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g); 
	output=$(openssl x509 -noout -text -in "$i" | grep OCSP);
	if [[ $output =~ URI:(.+)$ ]]; then
			aia=${BASH_REMATCH[1]};
	    echo $i" : ["$aia"]";
	    echo $aia > "tmp/aia"$I".txt";
	else
	    echo "Authority Information Access url: []"
	fi
done

# add certificate chain to the CAbundle
q='{0,';
for i in tmp/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g);
	q=$q$(($I+1))','
done
q='tmp/level'${q::-3}'}.crt'
cmd='cat /etc/ssl/certs/ca-certificates.crt '$q' > '$CAF
eval $cmd

# verifying the chain 
for i in tmp/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g)	
	for j in tmp/level?.crt; do
		J=$(echo "$j" | sed -e s/[^0-9]//g)
  	if [ "$J" -eq $(($I+1)) ]; then
			printf "**********************\nVerifying Level ["$I"]\n----------------------\n"
			aiaurl=$(cat tmp/aia$I.txt)
			echo "OCSP URL ["$aiaurl"]";
			serial=$(openssl x509 -serial -noout -in $i); 
			serial=${serial#*=};
			openssl ocsp -issuer $j -CAfile $CAF -VAfile $CAF -url $aiaurl -serial "0x${serial}" -out "tmp/result"$I".txt"
		fi		
	done
done

# print the file index so that the max is the number returned
# for i in level?.crt; do
# 	echo $(echo "$i" | sed -e s/[^0-9]//g)	
# done