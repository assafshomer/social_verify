#!/bin/bash

# print data about each certificate
for i in level?.crt; do
	echo "**************************\nInspecting "$i" cert \n-------------------------\n"
	openssl x509 -noout -serial -subject -issuer -dates -in "$i"; 
	echo; 
done