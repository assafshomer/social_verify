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
 * Website: http://colu.co
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

### JSON
To verify an asset with e.g. asset id `LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX` the user should 
* Tweet
* Add something to the asset metadata

#### Tweet
The user should make a tweet with the following text
```
	"Verifying issuance of colored coins asset with asset_id: [LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX]"
```
Then go to the tweet as it appears on his feed, click on the "copy link to tweet" on the menu, which looks something like this:
```
	https://twitter.com/assaf_colu/status/651645990554968064
```
The information we need is just the numeric id that appears at the end of the link.
#### Metadata
The asset metadata should include a `verifications` key with tweet text and the following content
"verifications: {
	"social":{
		"twitter":{
			"text": "Verifying issuance of colored coins asset with asset_id: [LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX]",
			"pid":"651645990554968064"
		}
	}
}

### Test
Open the file `test/networks/twitter_text.php` in your browser


