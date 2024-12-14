#!/bin/bash

echo "Installing Nginx..."

# Install Nginx
sudo apt install nginx -y

# Start and enable Nginx service
sudo systemctl start nginx
sudo systemctl enable nginx

# Check Nginx status
sudo systemctl status nginx

echo "Nginx installed and running successfully!"

