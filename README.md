# social_verify

php libraries for verifying colored coins asset issuance.

## TWITTER

### Generate API tokens
The helper file twitter_get_tokens.php reaches out to twitter_api for a bearer token and caches it locally on twitter_bearer_token.txt

* Open a twitter account
* Sing in
* You must add your mobile phone to your Twitter profile before creating an application
* navigate to https://apps.twitter.com
* create a new application
 * WEBSITE: http://colu.co
 * Callback URL: <leave blank>
* Navigate to the "Keys and Access Tokens" tab
* Save the consumer key and consumer secret in a file networks/twitter/twitter_app_secrets.txt in the following format:
```PHP
# networks/twitter/twitter_app_secrets.txt
<?php

define('CONSUMER_KEY', '*****************');
define('CONSUMER_SECRET', '********************************************');

?>

```
* You don't need to creat an access token
* The bearer_token files (initially empty) is required

### Test
Open the file `test/networks/twitter_text.php` in your browser





