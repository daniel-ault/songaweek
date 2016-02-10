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
	
	clear_database()

	for f in files:
		add_songs(f)

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
			query = "INSERT INTO songs (artist_id, url, title, week) VALUES (" + str(artist_id) + ", '" + song + "', '" + str(title) + "', " + str(week_num) + ");"
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

def get_song_title(url):
	if "youtu" in url:
		return get_song_name_youtube(url)
	elif "soundcloud" in url:
		return get_song_name_soundcloud(url)
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



main()
