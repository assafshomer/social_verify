#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

# extract domain from url
URL='https://bankofamerica.com';
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;
printf "Processing domain ["$DOMAIN"]\n*******************************************\n";

# remove auxiliary files
TMP_SUBDIR="$(echo $DOMAIN|awk '{gsub("\\.", "_")}1';)"
rm -rf tmp/*.*;
mkdir -p tmp/$TMP_SUBDIR;
# chmod -R 777 tmp/$TMP_SUBDIR;
# define the name of the certificates file
CAF='CAbundle.crt';

# define the url for getting the mozilla.org certificates
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
             inc {print > ("tmp/'$TMP_SUBDIR'/level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'

# print data about each certificate
for i in tmp/$TMP_SUBDIR/level?.crt; do
	printf "**************************\nInspecting "$i" cert \n-------------------------\n"
	openssl x509 -noout -serial -subject -issuer -dates -in "$i"; 
	echo; 
done

# grab Authority information access url from certificates and save to aia#.txt
printf "Authority Information Access urls\n****************************************\n"
for i in tmp/$TMP_SUBDIR/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g); 
	# echo "processing [$i]:"; 
	output=$(openssl x509 -noout -text -in "$i" | grep OCSP);
	if [[ $output =~ URI:(.+)$ ]]; then
			aia=${BASH_REMATCH[1]};
	    echo $i" : ["$aia"]";
	    echo $aia > "tmp/"$TMP_SUBDIR"/aia"$I".txt";
	else
	    echo "Authority Information Access url: []"
	fi
done

# add certificate chain to the CAbundle
q='{0,';
for i in tmp/$TMP_SUBDIR/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g);
	q=$q$(($I+1))','
done
q='tmp/'$TMP_SUBDIR'/level'${q::-3}'}.crt'
cmd='cat /etc/ssl/certs/ca-certificates.crt '$q' > '$CAF
eval $cmd

# verifying the chain 
for i in tmp/$TMP_SUBDIR/level?.crt; do
	I=$(echo "$i" | sed -e s/[^0-9]//g)	
	for j in tmp/$TMP_SUBDIR/level?.crt; do
		J=$(echo "$j" | sed -e s/[^0-9]//g)
  	if [ "$J" -eq $(($I+1)) ]; then
			printf "**********************\nVerifying Level ["$I"]\n----------------------\n"
			aiaurl=$(cat tmp/$TMP_SUBDIR/aia$I.txt)
			echo "OCSP URL ["$aiaurl"]";
			serial=$(openssl x509 -serial -noout -in $i); 
			serial=${serial#*=};
			openssl ocsp -issuer $j -CAfile $CAF -VAfile $CAF -url $aiaurl -serial "0x${serial}"
		fi		
	done
done