#!/bin/bash

data=$(openssl x509 -noout -subject -in tmp/level0.crt);
echo $data;