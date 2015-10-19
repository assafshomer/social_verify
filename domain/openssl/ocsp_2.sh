#!/bin/bash

# get level from cmd arg
LEVEL=$1;

# echo data about the certificate at given level
data=$(openssl x509 -noout -issuer -in tmp/level$LEVEL.crt);
tmp=$data;
if [[ $tmp =~ CN=(.+)issuer ]]; then
 domain=${BASH_REMATCH[1]};
fi;
tmp=$data;
if [[ $tmp =~ O=(.+)(,|=Network) ]]; then
 company=${BASH_REMATCH[1]};
fi;
if [[ $company =~ (.+)\/OU ]]; then
 company=${BASH_REMATCH[1]};
fi;

output="{domain:'"${domain::-1}"',company:'"${company}"'}";
echo $data;