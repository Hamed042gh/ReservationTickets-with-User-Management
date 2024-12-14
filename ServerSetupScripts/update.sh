#!/bin/bash
echo "Updating System..."
# Update package list
sudo apt update

# Upgrade all packages
sudo apt upgrade -y

# Clean up unused packages
sudo apt autoremove -y

