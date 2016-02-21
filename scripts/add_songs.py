import sys
import csv
import mysql.connector
import requests
import glob, os
import re

def main():
	#if len(sys.argv) == 1 or len(sys.argv) > 3:
	#	print "Please give one filename to input in the database."
	#	sys.exit(0)
	
	files = []

	os.chdir("./csv")
	for file in glob.glob("week*.csv"):
		files.append(file)	
	
	files.sort()
	
	clear_database()

	for f in files:
		add_songs(f)
	
	add_ringer_song();

	# end main

def add_songs(filename):
	
	week_num = filename[4]

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
			artist = row[0];
			song = row[1];
			if "http" not in song:
				song = "https://" + song
			title = get_song_title(song)
			query = "SELECT id FROM artists WHERE name='" + artist + "';";
			cursor.execute(query)
			artist_id = cursor.fetchall()[0][0]
			site_id = get_site_id(song)
			query = ("INSERT INTO songs " 
						"(artist_id, url, title, week, site_id) "
						"VALUES (" + str(artist_id) + 
						", '" + song + 
						"', '" + str(title) + 
						"', " + str(week_num) + 
						", " + str(site_id) + ");"
						)
			print query
			cursor.execute(query)

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

def get_site_id(url):
	config = {
		'user': 'python',
		'password': '',
		'host': 'localhost',
		'database': 'saw'
	}

	conn = mysql.connector.connect(**config)
	cursor = conn.cursor()
	
	site = ""

	if "youtu" in url:
		site = "Youtube"
	elif "soundcloud" in url:
		site = "Soundcloud"
	elif "tumblr" in url or "tmblr" in url:
		site = "Tumblr"
	elif "bandcamp" in url:
		site = "Bandcamp"
	elif "reverbnation" in url:
		site = "Reverbnation"
	elif "drive.google" in url or "goo.gl" in url:
		site = "Google Drive"
	else:
		site = "Unsupported"

	query = "SELECT id FROM supported_sites WHERE name='" + site + "';"
	cursor.execute(query)
	
	site_id = cursor.fetchall()[0][0]

	conn.close()

	return site_id



def get_song_title(url):
	if "youtu" in url:
		return get_song_name_youtube(url)
	elif "soundcloud" in url:
		return get_song_name_soundcloud(url)
	elif "tumblr" in url and "post" in url:
		return get_title_tumblr(url)
	elif "tmblr" in url:
		return get_title_tumblr(url)
	elif "tumblr" in url:
		return get_tumblr_post(url)
	elif "bandcamp" in url:
		return get_song_name_bandcamp(url)
	elif "reverbnation" in url:
		return get_song_name_reverbnation(url)
	elif "drive.google" in url or "goo.gl" in url:
		return get_song_name_googledrive(url)
	else:
		return ""

def get_song_name_youtube(url):
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)
	song = ""

	for line in r.iter_lines():
		if song != "":
			#do nothing
			x = 1
		elif '<title>' in line:
			s = line
			s = s.split("title>")
			return s[1][0:-12]


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


def get_title_tumblr(url):
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)
	
	for line in r.iter_lines():
		if 'meta name="description"' in line:
			return line.split('"')[3]


def get_tumblr_post(url):
	if "http" not in url:
		url = "https://" + url
	
	url_post = url.split("/")[2] + "/post"
	r = requests.get(url, stream=True)

	for line in r.iter_lines():
		if url_post in line:
			for n in line.split('"'):
				if url_post in n:
					return get_title_tumblr(n)


def get_song_name_bandcamp(url):
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)

	for line in r.iter_lines():
		if '<div class="trackTitle">' in line:
			return re.split('<|>', line)[4]
			

def get_song_name_reverbnation(url):
	if "http" not in url:
		url = "https://" + url

	r = requests.get(url, stream=True)

	for line in r.iter_lines():
		if '<span class="song_name">' in line:
			return re.split('<|>', line)[2]


def get_song_name_googledrive(url):
	r = requests.get(url, stream=True)

	for line in r.iter_lines():
		if '<title>' in line:
			match = re.search(r'(<title>)(((?! - Google Drive).)*)', line)
			return match.group(2)


def add_ringer_song():	
	config = {
		'user': 'python',
		'password': '',
		'host': 'localhost',
		'database': 'saw'
	}

	conn = mysql.connector.connect(**config)
	cursor = conn.cursor()

	query = "INSERT INTO songs (artist_id, url, title, week, site_id) VALUES (9, 'https://steveringer.bandcamp.com/track/w03-latenight', 'W03_LateNight', 3, 4);"

	cursor.execute(query)
	conn.commit()
	conn.close()

main()
