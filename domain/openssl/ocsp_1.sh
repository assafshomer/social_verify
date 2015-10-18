#!/bin/bash
# http://backreference.org/2010/05/09/ocsp-verification-with-openssl/

# extract domain from url
URL=$1;
echo "url".$URL
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;
echo "Processing domain ["$DOMAIN"]\n*******************************************\n";
cd ${0%/*}