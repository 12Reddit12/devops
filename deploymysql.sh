#!/bin/bash
set -e

echo "** Installing MySQL **"
sudo apt-get update -y
sudo apt-get install -y wget lsb-release gnupg

wget https://dev.mysql.com/get/mysql-apt-config_0.8.22-1_all.deb
sudo dpkg -i mysql-apt-config_0.8.22-1_all.deb
sudo apt-get update -y

sudo apt-get install -y mysql-server

MYSQL_ROOT_PASSWORD="todolistpswd"

echo "** Starting MySQL service **"
sudo systemctl start mysql

echo "** Setting MySQL root password **"
sudo mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '$MYSQL_ROOT_PASSWORD';"

echo "** Initializing database **"
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS todolist;"
curl -o /tmp/init.sql https://raw.githubusercontent.com/12Reddit12/devops/refs/heads/main/init.sql
sudo mysql -u root -p"$MYSQL_ROOT_PASSWORD" todolist < /tmp/init.sql

echo "** MySQL setup completed **"
