## Kivon - Simple keyword extractor in Python

Kivon is a simple keyword extractor implemented in Python as a part of hobby to learn the language. This project is made open source in order to allow everyone using the library fork and contribute to make it more effective.

## Installation

Kivon has a few dependencies which need to be installed as prequisites using `pip`:

                pip install urllib3
                pip install nltk
                pip install beautifulsoup4
                pip install python-dateutil

After installing the libraries place the kivon.py inside your root folder. Using the following sample code you can fetch the keywords:

                from kivon import Extract as kv

                try:
                    content_file = open("data.txt","w+")
                    link = input("Enter a valid URL: ")
                    content = kv.fetchContent(link)
                    content_plain = kv.contentPlain(content)
                    words_list = kv.fetchWords(content_plain)
                    print(words_list)                    
                except:
                    print('Error parsing the link')

## Credits

The library is written by Sanket Raut. In case if you want to get in touch with him on LinkedIn follow the link mentioned below:
    https://www.linkedin.com/in/sanket-raut-84875a96/