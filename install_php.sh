#!/bin/bash

echo "Installing PHP 8.2 and extensions..."

# Adding the repository for PHP 8.2 (if not already added)
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Installing PHP 8.2 and required extensions
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-cli php8.2-curl php8.2-xml php8.2-mbstring php8.2-zip php8.2-soap php8.2-intl php8.2-bcmath -y

# Restarting PHP-FPM service to apply changes
sudo systemctl restart php8.2-fpm

echo "PHP 8.2 and extensions installed successfully!"

