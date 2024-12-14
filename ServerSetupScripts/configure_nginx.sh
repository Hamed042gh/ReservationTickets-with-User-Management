#!/bin/bash

echo "Configuring Nginx..."

# Backup the default config file
sudo cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup

# Edit the default configuration file to process PHP files
sudo sed -i 's/index index.html/index index.php index.html/g' /etc/nginx/sites-available/default
sudo sed -i 's/#location ~ \\.php\$ {/location ~ \\.php\$ {/g' /etc/nginx/sites-available/default
sudo sed -i 's/#\tfastcgi_pass unix:\/var\/run\/php\/php7.2-fpm.sock;/\tfastcgi_pass unix:\/var\/run\/php\/php8.2-fpm.sock;/g' /etc/nginx/sites-available/default
sudo sed -i 's/#\tinclude snippets\/fastcgi-php.conf;/\tinclude snippets\/fastcgi-php.conf;/g' /etc/nginx/sites-available/default
sudo sed -i 's/#\tfastcgi_param SCRIPT_FILENAME/fastcgi_param SCRIPT_FILENAME/g' /etc/nginx/sites-available/default
sudo sed -i 's/#\tinclude fastcgi_params;/\tinclude fastcgi_params;/g' /etc/nginx/sites-available/default

# Restart Nginx to apply changes
sudo systemctl restart nginx

echo "Nginx configured to process PHP successfully!"

