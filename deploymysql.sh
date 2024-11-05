#!/bin/bash
set -e

echo "** Installing MySQL **"
sudo apt-get update -y

sudo apt-get install -y wget lsb-release gnupg


wget https://dev.mysql.com/get/mysql-apt-config_0.8.22-1_all.deb
sudo dpkg -i mysql-apt-config_0.8.22-1_all.deb
sudo apt-get update -y

echo "** Installing MySQL Server **"
sudo apt-get install -y mysql-server

echo "** Downloading init.sql **"
curl -o /tmp/init.sql https://raw.githubusercontent.com/12Reddit12/devops/refs/heads/main/init.sql

echo "** Starting MySQL service **"
sudo systemctl start mysql

echo "** Initializing database **"
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS todolist;"
sudo mysql -u root todolist < /tmp/init.sql

echo "** MySQL setup completed **"
