#!/bin/bash

# get url from cmd arg
URL=$1;

# extract domain from url
if [[ $URL =~ https://(.+)$ ]]; then
 DOMAIN=${BASH_REMATCH[1]};
fi;

# extract tag from domain
TAG="$(echo $DOMAIN|awk '{gsub("\\.", "_")}1';)"

# change to current dir
cd ${0%/*};

data=$(openssl x509 -noout -subject -in tmp/"$TAG"_level0.crt);
echo $data;