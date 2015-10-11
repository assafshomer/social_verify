# social_verify

php libraries for verifying colored coins asset issuance.

## TWITTER

### Generate API tokens
The helper file twitter_get_tokens.php reaches out to twitter_api for a bearer token and caches it locally on twitter_bearer_token.txt

* Creat an account and sign in
* You must add your mobile phone to your Twitter profile before creating an application
* navigate to https://apps.twitter.com
* create a new application
 * Website: http://colu.co
 * Callback URL: <leave blank>
* Navigate to the "Keys and Access Tokens" tab
* Save the consumer key and consumer secret in a file `networks/twitter/twitter_app_secrets.php` in the following format:
```PHP
# networks/twitter/twitter_app_secrets.php
<?php

	define('CONSUMER_KEY', '*****************');
	define('CONSUMER_SECRET', '********************');

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
The asset metadata should include a `verifications` key with tweet id with the following syntax:
```
"verifications: {
	"social":{
		"twitter":{
			"pid":"<postID>"
		}
	}
}
```
In our example this would be

``` 
"verifications: {
	"social":{
		"twitter":{
			"pid":"651645990554968064"
		}
	}
}
```

### USE
The function that does the verification is `twitter_verify_asset($verifications_json)` sitting in `verify_tweet.php`.
It is expecting a verification json input with the following structure:
```
{
	"social":{
		"twitter":{
			"aid":"<assetID>",
			"pid":"<postID>"
		}
}
```
In our example this would be

```
{
	"social":{
		"twitter":{
			"aid":"LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX",
			"pid":"651645990554968064"
		}
}
```
Note that the `aid` (short for AssetID) is not included in the metadata because the explorer already knows that.

### Test
Open `test/networks/twitter_text.php` in your browser.




# FACEBOOK

* Creat an account and sign in
* Navigate to https://developers.facebook.com/
* Click on the `My Apps` tab
* Register as a developer
* Click again on the `My Apps` tab
* Create a new application
* Select the `www` option and click on the top left `skip and create App ID`
 * Display Name: coloredcoins
 * Namespace: <leave blank>
 * Category: Finance
* Answer the kaptch and create app id
* Navigate again to the `My Apps` tab and select the `coloredcoins` application
* Navigate to the "Dashboard" tab
* Save the `App ID` and `App Secret` in a file `networks/facebook/fb_app_secrets.php` in the following format:

```PHP
# networks/facebook/fb_app_secrets.txt
<?php

	define('FB_APP_ID', '**************');
	define('FB_APP_SECRET', '**************************');

?>

```

* Now click on the `Tools & Support` tab and select `Graph API Explorer`
* On the top left there is a pulldown showing `Graph API Explorer`, click on it and select the option `coloredcoins` for the app you created.
* Now go one line down to the `Get Token` pulldown and select `Get App Token`
* Add that to the secrets file like so:

```PHP
# networks/facebook/fb_app_secrets.txt
<?php

	define('FB_APP_ID', '**************');
	define('FB_APP_SECRET', '**************************');
	define('FB_APP_TOKEN', '**************|************');

?>

```

*  Now we need a short lived access token that can be extended using the above secrets. We get that by clicking on the `Get Token` pulldown and select `Get Access Token`
* Set the token permissions to `user_posts`
* Click OK
* Copy the Access Token to your clipboard and save it in the `fb_access_token.txt` file
* Now open the file `networks/facebook/get_access_token.php` in a browser and copy the extended access token to your clipboard. 
* Save the extended access token




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
The asset metadata should include a `verifications` key with tweet id with the following syntax:
```
"verifications: {
	"social":{
		"twitter":{
			"pid":"<postID>"
		}
	}
}
```
In our example this would be

``` 
"verifications: {
	"social":{
		"twitter":{
			"pid":"651645990554968064"
		}
	}
}
```

### USE
The function that does the verification is `twitter_verify_asset($verifications_json)` sitting in `verify_tweet.php`.
It is expecting a verification json input with the following structure:
```
{
	"social":{
		"twitter":{
			"aid":"<assetID>",
			"pid":"<postID>"
		}
}
```
In our example this would be

```
{
	"social":{
		"twitter":{
			"aid":"LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX",
			"pid":"651645990554968064"
		}
}
```
Note that the `aid` (short for AssetID) is not included in the metadata because the explorer already knows that.

### Test
Open `test/networks/twitter_text.php` in your browser.