#!/bin/sh

wget https://dev.mysql.com/get/Downloads/Connector-Python/mysql-connector-python_2.1.3-1ubuntu14.04_all.deb;
sudo dpkg -i mysql-connector-python_2.1.3-1ubuntu14.04_all.deb;
rm mysql-connector-python_2.1.3-1ubuntu14.04_all.deb;
