from twython import Twython,  TwythonError
import random
import feedparser
import config



twitter = Twython(config.APP_KEY, config.APP_SECRET, config.OAUTH_TOKEN, config.OAUTH_TOKEN_SECRET)

# Searching tweets matching a term
terms = config.terms
rss = config.feeds

x = random.randint(0,len(terms) - 1)
results = twitter.search(q=terms[x], count=20)

try:
    y = random.randint(1,20)
    count = 0

    feed_y = random.randint(1,len(rss) - 1)
    feed_count = 0

    flag = random.randint(0,5)
    for tweet in results['statuses']:
        count = count + 1
        if count == y:
            print 'Sending tweet...'
            twitter.retweet(id=tweet["id_str"])
            print 'Tweet sent successfully'
    # print flag
    # print feed_y
    if flag >= 1:
        for link in rss:
            feed_count = feed_count + 1
            # print feed_count
            if feed_count == feed_y:
                dlist = feedparser.parse(link)
                # print dlist['entries']
                selected_count = random.randint(1,len(dlist['entries']) - 1)
                tweet_count = 0
                for postlinks in dlist['entries']:
                    tweet_count = tweet_count + 1
                    if tweet_count == selected_count:
                        twitter.update_status(status=postlinks['link'])
                        print 'Status posted successfully'

except TwythonError as e:
    print e
