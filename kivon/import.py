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