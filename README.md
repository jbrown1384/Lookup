<p align="center">Customer LookUp App</p>

<p align="center">
    <a target="_blank" href="http://52.14.232.222/" alt="Build Status"><strong>Working Instance Link</strong></a>
</p>

## Stack

- AWS t.2 micro
- Ubuntu 18.04 (https://help.ubuntu.com/lts/installation-guide/)
- nginx v1.14.0 (https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)
- PHP v7.4.1 
- Laravel Framework v6.10.1
- MySql v14.14 Dist. v5.7.28,
- composer v1.9.1
- node v8.10.0
    - npm v3.5.2
- git v2.17.1


## Deployment
- Checkout this repo into the instance root directory
- composer and nodejs/npm can be installed individually or you can run the deploy script which will auto install and create the dependencies 
    - To run the deploy script: sudo bash ./public/scripts/deploy.sh 
    - this will install and run composer and npm

## Quick Deployment commands for setting up full environment
### Install Nginx
- sudo apt update
- sudo apt install nginx -y

### Install MySql Server
- sudo apt install mysql-server -y
- sudo mysql_secure_installation
	- answer prompts

### Alter root user permissions
	- sudo mysql
	- ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
	- FLUSH PRIVILEGES;
	- exit

### Install PHP
- sudo apt install software-properties-common -y
- sudo add-apt-repository ppa:ondrej/php -y
- sudo apt update
- sudo apt install php7.4-fpm php7.4-mysql php7.4-common php7.4-mysql php7.4-xml php7.4-xmlrpc php7.4-curl php7.4-gd php7.4-imagick php7.4-cli php7.4-dev php7.4-imap php7.4-mbstring php7.4-opcache php7.4-soap php7.4-zip unzip -y
- sudo nano /etc/php/7.4/fpm/php.ini

### Nginx Config
- sudo nano /etc/nginx/sites-available/Lookup

### Enter this configuration into the Lookup file, remember to update your public IP into the server_name field
```
server {
    listen 80;
    listen [::]:80;
    root /var/www/html/Lookup/public;
    index  index.php index.html index.htm;
    server_name {ENTER_PUBLIC_IP_HERE};

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
       include snippets/fastcgi-php.conf;
       fastcgi_pass             unix:/var/run/php/php7.4-fpm.sock;
       fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

- sudo ln -s /etc/nginx/sites-available/Lookup /etc/nginx/sites-enabled/
- sudo service nginx restart

### Install Laravel
- cd /var/www/html
- sudo apt install git -y
- sudo git clone https://github.com/jbrown1384/Lookup.git
- cd Lookup/
- sudo chown -R www-data:www-data /var/www/html/Lookup/
- sudo chmod -R 755 /var/www/html/Lookup/
- sudo cp .env.example .env
- sudo bash ./public/scripts/deploy.sh

## Application
