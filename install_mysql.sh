#!/bin/bash

echo "Installing MySQL..."

# Update system package list
sudo apt update

# Install MySQL server
sudo apt install mysql-server -y

# Run the secure installation script
sudo mysql_secure_installation

echo "MySQL installed and secured successfully!"

