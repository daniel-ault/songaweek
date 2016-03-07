import sys
import csv
import mysql.connector
import requests
import glob, os
import re
import urllib2

def main():
	if len(sys.argv) > 2:
		print "Please give one week to input in the database, or give no arguments and it will add all weeks."
		sys.exit(0)

	if len(sys.argv) == 1:
		add_all()
	elif len(sys.argv) == 2:
		match = re.match(r'^[0-9]+$', sys.argv[1])
		if match == None:
			print "Please enter in a week number value to enter that week's data into the database,"
			print "or do not give any arguments to enter every week into the database."
			sys.exit(0)
		
		add_week(sys.argv[1])


	# end main

def add_week(week):
	f = "./csv/week" + week + ".csv"

	if os.path.isfile(f):
		add_artists(f)
	else:
		print "File \"" + f + "\" does not exist."



def add_all():
	files = []

	os.chdir("./csv")
	for file in glob.glob("week*.csv"):
		files.append(file)	
	
	files.sort()
	
	for f in files:
		add_artists(f)

def add_artists(filename):

	config = {
		'user': 'python',
		'password': '',
		'host': 'localhost',
		'database': 'saw'
	}

	conn = mysql.connector.connect(**config)
	cursor = conn.cursor()

	with open(filename, 'rb') as csvfile:
		week1 = csv.reader(csvfile, delimiter=',')
		for row in week1:
			#comment out lines in the csv files
			if row[0][0] == "#":
				continue
			artist = row[0]
			query = "SELECT COUNT(*) FROM artists WHERE name = '" + artist + "';"
			print query
			cursor.execute(query)
			exists = cursor.fetchall()[0][0]
			if exists == 0:
				print artist + " is a new artist."
				query = "INSERT INTO artists (name)  VALUES('" + row[0] + "');"
				print query
				cursor.execute(query)
			else:
				print artist + " already exists"
			

			conn.commit()
			query = "SELECT id FROM artists WHERE name = '" + artist + "';"
			cursor.execute(query)
			#print cursor.fetchall()[0][0]
			artist_id = cursor.fetchall()[0][0]

			sites = {'youtu': 1, 
						'soundcloud': 2, 
						'mblr': 3, 
						'bandcamp': 4,
						'reverbnation': 5}

			for url_part in sites.iterkeys():
				if url_part in row[1]:
					site_id = sites[url_part]
					link = '';
					if site_id == 1:
						link = get_artist_link_youtube(row[1])
					elif site_id == 2:
						link = get_artist_link_soundcloud(row[1])
					elif site_id == 3:
						link = get_artist_link_tumblr(row[1])
					elif site_id == 4:
						link = get_artist_link_bandcamp(row[1])
					elif site_id == 5:
						link = get_artist_link_reverbnation(row[1])
					
					# If the link ends in .com or .com/, then that means that there is no profile
					# link, the page is set to private or something.
					# Except if it's bandcamp, the format there is
					# user.bandcamp.com
					# Also, ^ is logical XOR in python
					if ("bandcamp" in link or "tumblr" in link) ^ (not (link.endswith(".com") or link.endswith(".com/"))):
						query = ("SELECT COUNT(*) "
									"FROM accounts "
									"WHERE artist_id=" + str(artist_id) + 
									" AND site_id=" + str(site_id) + 
									" AND url='" + link + "';"
									)
						print query
						cursor.execute(query)
						exists = cursor.fetchall()[0][0]
						if exists == 0:
							query = "INSERT INTO accounts(url, artist_id, site_id) VALUES('" + link + "', " + str(artist_id) + ", " + str(site_id) + ");"
							cursor.execute(query)
							print query
			conn.commit()	
			#print cursor.fetchall()[0][0]	
	conn.commit()
	conn.close()


def clear_database():
	config = {
		'user': 'python',
		'password': '',
		'host': 'localhost',
		'database': 'saw'
	}
	
	conn = mysql.connector.connect(**config)
	cursor = conn.cursor()
	
	query = "DELETE FROM songs;"
	cursor.execute(query)
	query = "TRUNCATE TABLE songs;"
	cursor.execute(query)

	conn.close()



def get_artist_link_youtube(url):
	if "www" not in url and "youtu.be" not in url:
		match = re.match( r'(https*://)?(.*)', url)
		url = "https://www." + match.group(2)
			
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)
	artist = "" 

	for line in r.iter_lines():
		if artist != "":
			#do nothing
			x = 1
		elif '<a href="/channel' in line:
			s = line
			s = s.split()
 			for string in s:
 				if '/channel' in string:
	 				if artist == "":
		 				artist = string[6:-1]

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


def get_artist_link_soundcloud(url):
	if "www" not in url:
		match = re.match( r'(https*://)?(.*)', url)
		url = "https://www." + match.group(2)
	
	if "http" not in url:
		url = "https://" + url

	url = url.split("/")
	
	artist = ""
	for i in range(0, 4):
		artist = artist + url[i] + "/"
	
	return artist


def get_artist_link_tumblr(url):
	if "tmblr" in url:
		response = urllib2.urlopen(url)
		url = response.url



	match = re.match(r'(https?://)?([a-z1-9]*.tumblr.com)(.*)', url)
	new_url = "https://" + match.group(2)
	return new_url


def get_artist_link_bandcamp(url):
	match = re.match(r'(https?://)?([a-z1-9]*.bandcamp.com)(.*)', url)
	new_url = "https://" + match.group(2)
	return new_url


def get_artist_link_reverbnation(url):
	return get_artist_link_soundcloud(url)


main()
