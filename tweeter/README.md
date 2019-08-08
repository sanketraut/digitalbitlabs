## Tweeter

Tweeter is a simple python bot script, which retweets and shares the articles automatically. 
You can setup a cron job pointing to tweeter.py and let the bot work for you. :)

It's simple to configure the script. Simply create a twitter app through its developer section and specify the following parameters  in config.py

* APP_KEY = '<app_key>'
* APP_SECRET = '<app_secret>'
* OAUTH_TOKEN = '<oauth_token>'
* OAUTH_TOKEN_SECRET = '<oauth_token_secret>'

* terms = [] //array specifying the terms you want to tweet about
* feeds = [] //source of rss feeds

Then set it up as a cron job and it will start sending tweets or retweeting through your account. Be considerate not to overload the Twitter server with large number of requests else Twitter may block your account.
