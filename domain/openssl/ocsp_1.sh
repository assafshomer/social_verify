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
rm -f aia*.txt;
rm -f level*.crt;

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
             inc {print > ("level" c ".crt")}
             /---END CERTIFICATE-----/{inc=0}'

# print the file index so that the max is the number returned
for i in level?.crt; do
	echo $(echo "$i" | sed -e s/[^0-9]//g)	
done