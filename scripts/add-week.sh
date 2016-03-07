#!/bin/sh

# use by "./add-week.sh {week-number}

python add_artists.py $1
python add_songs.py $1
