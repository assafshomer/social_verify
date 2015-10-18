#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

# extract domain from url
URL=$1;
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;
echo $DOMAIN;
cd ${0%/*}
# remove auxiliary files
rm -f aia*.txt;
rm -f level*.crt;

# # define the name of the certificates file
# CAF='CAbundle.crt';

# # print data about each certificate
# for i in level?.crt; do
# 	echo "**************************\nInspecting "$i" cert \n-------------------------\n"
	
# 	echo; 
# done