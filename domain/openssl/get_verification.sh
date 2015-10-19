#!/bin/bash

# get level from cmd arg
LEVEL=$1;

data=$(openssl x509 -noout -subject -in tmp/result$LEVEL.txt);
echo $data;