# social_verify

php libraries for verifying colored coins asset issuance.

## Twitter

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




## Facebook
### Generate API token
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
* Answer the kaptcha and create app id
* Navigate to the `Tools & Support` tab and select `Access Token Tools`
* Copy your app token to the clipboard and save it in a file `networks/facebook/fb_app_secrets.php` in the following format:

```PHP
# networks/facebook/fb_app_secrets.txt
<?php
	define('FB_APP_TOKEN', '**************|************');
?>

```

### JSON
To verify an asset the user should
* Post to the "Colored Coins Asset Verification" page
* Add something to the asset metadata

#### POST

* Log in to facebook
* Search for the "Colored Coins Asset Verification" page
* Post the following text to that page
```
	"Verifying issuance of colored coins asset with asset_id: [<asset ID>]"
```
For example
```
	"Verifying issuance of colored coins asset with asset_id: [LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX]"
```
* After posting you will be redirected to your post
* Right click on the Timestamp link on the post (right below your user name) and extract the Post ID by selecting "copy link address" 

![Alt text](/shared/images/fb_story_id.png?raw=true "Extracting the post ID")

* The link address will look something like:
<pre>
  https://www.facebook.com/permalink.php?<b>story_fbid=486035954907151</b>&id=486034634907283
</pre>
* The Post ID (or Story ID) is the first number `486035954907151`
* Finally, we also need your facebook user ID (or Profile ID). You can get that by visiting [this service](http://findmyfbid.com/).

#### Metadata
The asset metadata should include a `verifications` key with `postID` and `userID` in the following syntax:
```
"verifications: {
	"social":{
		"facebook":{
			"uid":"<userID>"
			"pid":"<postID>"
		}
	}
}
```
In our example this would be

``` 
"verifications: {
	"social":{
		"facebook":{
			"uid":"1232952150",
			"pid":"486035954907151"			
		}
	}
}
```

### USE
The function that does the verification is `fb_verify_asset($verifications_json)` sitting in `verify_post.php`.
It is expecting a verification json input with the following structure:
```
{
	"social":{
		"twitter":{
			"aid":"<assetID>",
			"uid":"<userID>",
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
			"uid":"1232952150",
			"pid":"486035954907151"	
		}
}
```
Note that the `aid` (short for AssetID) is not included in the metadata because the explorer already knows it.

### Test
Open `test/networks/facebook_text.php` in your browser.

## Github
### [Generate API token](https://help.github.com/articles/creating-an-access-token-for-command-line-use/)
* Create an [account](https://github.com/coloredcoinsassetverification) on Github
* In the top right corner of any page, click your profile photo, then click **Settings**.
* In the user settings sidebar, click **Personal access tokens**.
* Click **Generate new token** and name it.
* Use the default scope, this is enough to read gists which is all we need.
* Copy the token to your clipboard and save it a file `networks/github/github_app_secrets.php` in the following format:
```PHP
# networks/twitter/twitter_app_secrets.php
<?php
	define('GITHUB_PERSONAL_TOKEN', '*****************');
?>

```
* This token is [limited](https://developer.github.com/v3/#rate-limiting) to 5000 calls/hour. 

### JSON
To verify an asset with e.g. asset id `LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX` the user should 
* Post a [public gist](https://help.github.com/articles/about-gists/)
* Add something to the asset metadata

#### Create a public gist
The user should create a public gist with the following text
```
	"Verifying issuance of colored coins asset with asset_id: [<assetID>]"
```

![Alt text](/shared/images/public_gist.png?raw=true "Creating a public Gist")

* You can name the gist however you want.
* Grab the gist ID `6c704f5759927212e714` either from the name of the gist <pre>gist:<b>6c704f5759927212e714</b></pre> or the url <pre>https://gist.github.com/assafshomer/<b>6c704f5759927212e714</b></pre>

#### Metadata
The asset metadata should include a `verifications` key with gist id with the following syntax:
```
"verifications: {
	"social":{
		"github":{
			"pid":"<gistID>"
		}
	}
}
```
In our example this would be

``` 
"verifications: {
	"social":{
		"github":{
			"pid":"6c704f5759927212e714"
		}
	}
}
```

### USE
The function that does the verification is `github_verify_asset($verifications_json)` sitting in `verify_gist.php`.
It is expecting a verification json input with the following structure:
```
{
	"social":{
		"github":{
			"aid":"<assetID>",
			"pid":"<postID>"
		}
}
```
In our example this would be

```
{
	"social":{
		"github":{
			"aid":"LJEC6Q2h9JKNvZqEC87TbEXvxm4br1uivb2QX",
			"pid":"6c704f5759927212e714"
		}
}
```
Note that the `aid` (short for AssetID) is not included in the metadata because the explorer already knows that.

### Test
Open `test/networks/github_text.php` in your browser.