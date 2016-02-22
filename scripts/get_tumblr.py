import sys
import csv
import mysql.connector
import requests
import glob, os

def main():
	url = "http://anokiartwork.tumblr.com/image/136991750148"
	
	print get_tumblr_title(url)
		
	#url = "www.soundcloud.com/our-abstract-mountain/shoegazer"
	#print get_song_name_soundcloud(url)
	# end main

def get_tumblr_post(url):
	if "http" not in url:
		url = "https://" + url
	
	url_post = url.split("/")[2] + "/post"
	r = requests.get(url, stream=True)

	for line in r.iter_lines():
		if url_post in line:
			for n in line.split('"'):
				if url_post in n:
					return n


def get_tumblr_title(url):
	if "http" not in url:
		url = "https://" + url
	
	url = get_tumblr_post(url)

	r = requests.get(url, stream=True)
	
	for line in r.iter_lines():
		if 'meta name="description"' in line:
			return line.split('"')[3]


	#get_song_name_youtube(url)

		'''
		if song != "":
			#do nothing
			x = 1
		elif '<title>' in line:
			s = line
			s = s.split("title>")
			return s[1][0:-12]
		'''

def get_song_name_soundcloud(url):
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)
	song = ""

	for line in r.iter_lines():
		if song != "":
			#do nothing
			x = 1
		elif 'itemprop="name"' in line:
			s = line
			s = s.split(">")
			return s[-2][0:-3]



	
	'''
	artist = "https://youtube.com" + artist
	
	r = requests.get(artist, stream=True)
	artist2 = ""	
	for line in r.iter_lines():
		if artist2 != "":
			#do nothing
			x = 1
		if 'youtube.com/user' in line:
			s = line.split('"')
			for string in s:
				if 'youtube.com/user' in string:
					if artist2 == "":
						artist2 = string
	
	if artist2 == "":
		return artist
	else:
		return artist2

	'''
	'''
	if "http" not in url:
		url = "https://" + url
	print url
	r = requests.get(url, stream=True)
	artist = "" 

	for line in r.iter_lines():
		if '<a href="/channel' in line:
			s = line
			s = s.split()
			for string in s:
				if '/channel' in string:
					if artist == "":
						artist = string[6:-1]

	artist = "https://youtube.com" + artist
	r = requests.get(artist, stream=True)
	
	for line in r.iter_lines():
		if 'youtube.com/user' in line:
			s = line.split('"')
			for string in s:
				if 'youtube.com/user' in string:
					artist = string

	return artist
	'''

def get_artist_link_soundcloud(url):
	if "http" not in url:
		url = "https://" + url

	url = url.split("/")
	
	artist = ""
	for i in range(0, 4):
		artist = artist + url[i] + "/"
	
	return artist



main()
