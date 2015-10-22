#!/bin/bash

# get url from cmd arg
URL=$1;

# extract domain from url
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;

# extract tag from domain www.foo.bar -> www_foo_bar
TAG="$(echo $DOMAIN|awk '{gsub("\\.", "_")}1';)"

# change to current dir
cd ${0%/*};

# define directory for cert files
CDIR='tmp/';

# define the name of certificate files
CAF=$CDIR'CAbundle.crt';
MAF=$CDIR'mozbunle.crt';

# define path to mozilla.org ca bundle
MB='https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt';

# copy the system CA certificates file for local use
cat /etc/ssl/certs/ca-certificates.crt > $CAF;

# add auto converted CA Certs from mozilla.org
wget -q -O $MAF $MB;
cat $MAF >> $CAF;

# import the certificate chain to files level0.crt, level1.crt etc
openssl s_client -showcerts -connect \
$DOMAIN:443 -CAfile $CAF < /dev/null | \
awk -v c=-1 '/-----BEGIN CERTIFICATE-----/{inc=1;c++} 
             inc {print > ("tmp/'$TAG'_level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'


# grab Authority information access url from certificates and save to aia#.txt
for i in "$CDIR$TAG"_level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g); 
	output=$(openssl x509 -noout -text -in "$i" | grep OCSP);
	if [[ $output =~ URI:(.+)$ ]]; then
			aia=${BASH_REMATCH[1]};
	    echo $aia > "tmp/"$TAG"_aia"$I".txt";
	fi
done

# add certificate chain to the CAbundle
q='{0,';
for i in "$CDIR$TAG"_level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g);
	q=$q$(($I+1))','
done
q=$CDIR$TAG'/level'${q::-3}'}.crt'
cmd='cat /etc/ssl/certs/ca-certificates.crt '$q' > '$CAF
eval $cmd

# verifying the chain 
for i in "$CDIR$TAG"_level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g)	
	for j in "$CDIR$TAG"_level?.crt; do
		J=$(echo "$j" | sed -e s/[^0-9]//g)
  	if [ "$J" -eq $(($I+1)) ]; then
			aiaurl=$(cat "$CDIR$TAG"_aia$I.txt)
			serial=$(openssl x509 -serial -noout -in $i); 
			serial=${serial#*=};
			openssl ocsp -issuer $j -CAfile $CAF -VAfile $CAF -url $aiaurl -serial "0x${serial}" -out $CDIR$TAG"_result"$I".txt"
		fi		
	done
done

# echo file indexes so that the max is the number returned to php
for i in "$CDIR$TAG"_level?.crt; do
	echo $(echo "$i" | sed -e s/[^0-9]//g)	
done