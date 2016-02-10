#!/bin/sh

mysql -u root -p < sql/create-db.sql;

python add_artists.py;
python add_songs.py;
