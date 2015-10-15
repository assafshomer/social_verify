openssl s_client -connect swarm.fund:443

openssl s_client -connect swarm.fund:443 | tee swarm.txt

echo QUIT | openssl s_client -connect swarm.fund:443 | sed -ne '/BEGIN CERT/,/END CERT/p'|


echo QUIT | openssl s_client -connect swarm.fund:443 | sed -ne '/BEGIN CERT/,/END CERT/p'| tee swarm.txt

openssl x509 -inform PEM -in cacert.pem -text -out swarm.txt

openssl verify -verbose -purpose sslserver -CAfile <file containing both root and intermediates> <file containing signed cert>

openssl verify -verbose -purpose sslserver -CAfile cacert.pem swarm.txt

openssl s_client -showcerts -connect swarm.fund:443