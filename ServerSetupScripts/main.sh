#!/bin/bash

# Ensure scripts have execute permissions
chmod +x install_php.sh install_mysql.sh install_nginx.sh configure_nginx.sh update.sh

# Update system
source update.sh

# Install PHP
source install_php.sh

# Install MySQL
source install_mysql.sh

# Install Nginx
source install_nginx.sh

# Configure Nginx
source configure_nginx.sh

# Configure Firewall
source ufw.sh

echo "All setup steps completed!"

