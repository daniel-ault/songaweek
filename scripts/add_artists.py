import sys
import csv
import mysql.connector
import requests
import glob, os

def main():
	#if len(sys.argv) == 1 or len(sys.argv) > 3:
	#	print "Please give one filename to input in the database."
	#	sys.exit(0)
	
	files = []

	os.chdir("./csv")
	for file in glob.glob("week*.csv"):
		files.append(file)	
	
	files.sort()
	
	for f in files:
		add_artists(f)

	# end main

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
			print artist_id

			sites = {'youtu': 1, 'soundcloud': 2}

			for url_part in sites.iterkeys():
				if url_part in row[1]:
					site_id = sites[url_part]
					link = '';
					if site_id == 1:
						link = get_artist_link_youtube(row[1])
					elif site_id == 2:
						link = get_artist_link_soundcloud(row[1])
					
					if not (link.endswith(".com") or link.endswith(".com/")):
						query = "SELECT COUNT(*) FROM accounts WHERE artist_id=" + str(artist_id) + " AND site_id=" + str(site_id) + ";"
						cursor.execute(query)
						exists = cursor.fetchall()[0][0]
						print exists
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
