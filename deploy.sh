#!/bin/bash
set -e

MYSQL_IP=$1

echo "** Installing nginx and git **"
sudo apt-get update
sudo apt-get install -y nginx git

echo "** Cloning website files **"
sudo git clone https://github.com/12Reddit12/devops.git /var/www/html
sudo chown -R www-data:www-data /var/www/html

echo "** Setting MySQL IP in config/db.php **"
sudo sed -i "s/'myappdb-service'/'$MYSQL_IP'/" /var/www/html/config/db.php

echo "** Enabling and restarting nginx **"
sudo systemctl enable nginx
sudo systemctl restart nginx

echo "** Startup script execution completed **"
