#!/bin/bash
set -e

echo "** Installing MySQL **"
sudo apt-get update -y
sudo apt-get install -y mysql-server curl

echo "** Downloading init.sql **"
curl -o /tmp/init.sql https://raw.githubusercontent.com/12Reddit12/devops/refs/heads/main/init.sql

echo "** Starting MySQL service **"
sudo systemctl start mysql

echo "** Initializing database **"
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS todolist;"
sudo mysql -u root todolist < /tmp/init.sql

echo "** MySQL setup completed **"
