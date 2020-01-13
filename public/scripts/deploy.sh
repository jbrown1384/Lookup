#!/bin/bash

##
#  Run this file any time that you need to update the code
#  on a server to ensure all required commands are completed
# #
echo "Install Composer"
sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
echo "Composer Installed"

echo "Installing composer packages"
sudo composer install

echo "Installing NodeJS version"
sudo apt-get install nodejs
echo "NodeJS installed"

echo "Installing NPM"
sudo apt-get install npm

echo "Installing all NPM packages"
sudo npm install --global cross-env

echo "Install Auth"
sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1
sudo composer require laravel/ui
sudo php artisan ui vue --auth

echo "Generating App Key"
sudo php artisan key:generate

echo "Running migrations"
sudo php artisan migrate

echo "Install Faker Data"
sudo php artisan tinker
# factory(App\Address::class, 30)->create();
# factory(App\Customer::class, 20)->create();

echo "Deployment script complete"
