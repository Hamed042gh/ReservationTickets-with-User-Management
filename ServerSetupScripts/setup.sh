#!/bin/bash

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

echo "All setup steps completed!"
