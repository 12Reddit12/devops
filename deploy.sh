#!/bin/bash
set -e

MYSQL_IP=$1

echo "** Installing nginx php-fpm and git **"
sudo apt-get update
sudo apt-get install -y nginx php-fpm php-mysql git

echo "** Cleaning up /var/www/html directory **"
sudo rm -rf /var/www/html/*

echo "** Cloning website files **"
sudo git clone https://github.com/12Reddit12/devops.git /var/www/html
sudo chown -R www-data:www-data /var/www/html

echo "** Setting MySQL IP in config/db.php **"
sudo sed -i "s/myappdb-service/$MYSQL_IP/g" /var/www/html/config/db.php

# Налаштування конфігурації Nginx для обробки PHP
cat <<EOL | sudo tee /etc/nginx/sites-available/default
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    server_name _;
    root /var/www/html;
    index index.php index.html index.htm;

    location / {
        try_files \$uri \$uri/ =404;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
}
EOL

echo "** Enabling and restarting nginx **"
sudo systemctl enable nginx
sudo systemctl restart nginx

echo "** Startup script execution completed **"
