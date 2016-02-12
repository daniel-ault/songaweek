DROP DATABASE IF EXISTS saw;

CREATE DATABASE saw;
USE saw;

CREATE TABLE IF NOT EXISTS artists
(
id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR(255),
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS songs
(
id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
artist_id SMALLINT UNSIGNED,
url VARCHAR(255),
title VARCHAR(255),
week SMALLINT UNSIGNED,
PRIMARY KEY (id),
FOREIGN KEY (artist_id) REFERENCES artists(id)
);

CREATE TABLE IF NOT EXISTS supported_sites
(
id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR(255),
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS accounts
(
id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
artist_id SMALLINT UNSIGNED,
site_id SMALLINT UNSIGNED,
url VARCHAR(255),
PRIMARY KEY (id),
FOREIGN KEY (artist_id) REFERENCES artists(id),
FOREIGN KEY (site_id) REFERENCES supported_sites(id)
);

INSERT INTO supported_sites(name) 
VALUES
("Youtube"),
("Soundcloud");


GRANT ALL PRIVILEGES ON artists TO 'python'@'localhost';
GRANT ALL PRIVILEGES ON songs TO 'python'@'localhost';
GRANT ALL PRIVILEGES ON supported_sites TO 'python'@'localhost';
GRANT ALL PRIVILEGES ON accounts TO 'python'@'localhost';
GRANT SELECT ON artists TO 'php'@'localhost';
GRANT SELECT ON songs TO 'php'@'localhost';
GRANT SELECT ON supported_sites TO 'php'@'localhost';
GRANT SELECT ON accounts TO 'php'@'localhost';
