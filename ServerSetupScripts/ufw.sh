#!/bin/bash

# Installing UFW if necessary
echo "Installing UFW..."
sudo apt install -y ufw

# Updating the firewall
echo "Updating package lists..."
sudo apt update

# Enabling UFW
echo "Enabling UFW firewall..."
sudo ufw enable

# Allowing ports 22 (SSH) and 80 (HTTP)
echo "Allowing ports 22 (SSH) and 80 (HTTP)..."
sudo ufw allow 22
sudo ufw allow 80

# Displaying firewall status
echo "Displaying current firewall status:"
sudo ufw status

