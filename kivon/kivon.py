import urllib.request
import nltk
import string
import bs4
import dateutil

from string import punctuation
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from bs4 import BeautifulSoup

try:
    nltk.data.find('tokenizers/punkt')
except:
    nltk.downloader.download('punkt')

try:
    nltk.data.find('corpora/stopwords')
except:
    nltk.downloader.download('stopwords')

class Extract:

    @classmethod
    def filterContent(cls, content):
        content  = ''.join(''.join(content.split('\t')).split('\r'))
        content = [x.strip() for x in content.split("\n")]
        return list(filter(None,content))

    @classmethod
    def fetchContent(cls, link):
        try:
            req = urllib.request.Request(link, headers = {'User-Agent': 'Mozilla/5.0'})
            response = urllib.request.urlopen(req)
            htmlBytes = response.read()
            htmlStr = htmlBytes.decode("utf8")
            soup = BeautifulSoup(htmlStr,'html.parser')
            return soup.find_all("p")
        except:
            return {"msg":"Content could not be parsed"}

    @classmethod
    def contentPlain(cls, content):
        content_plain = ''

        for line in list(content):
            try:
                punctuation = string.punctuation + '’'
                encoded_string = line.get_text()
                content_plain += ''.join(c for c in encoded_string  if c not in punctuation)
                return content_plain
            except:
                return ""

    @classmethod
    def fetchWords(cls, content):
        try:
            stop_words = stopwords.words('english')

            words_token = word_tokenize(content)

            filtered_tags = [w for w in words_token if w.lower() not in stop_words]

            words_freq = [filtered_tags.count(w) for w in list(set(filtered_tags)) if len(w) > 2]
            words_freq.sort()
            words_freq.reverse()
            max_words_count = words_freq[:5]

            words_freq_set = [{w:filtered_tags.count(w)} for w in list(set(filtered_tags))]
            words_list = [list(x.keys())[0].capitalize() for x in words_freq_set if list(x.values())[0] in max_words_count] 

            return words_list
        except:
            return {"msg":"Keywords could not be fetched"}