<p align="center">Customer LookUp App</p>

<p align="center">
    <a target="_blank" href="http://52.14.232.222/" alt="Lookup App"><strong>Working Instance Link</strong></a>
</p>

## Application
<p>The Lookup Application takes a customer ID and shows all connected data that is associated to that customer. The data that is retrieved will contain basic customer details, customer roles (many-to-many), and customer addresses (many-to-many). A working instance of the appication can be found <a target="_blank" href="http://52.14.232.222/" alt="Lookup App"><strong>here</strong></a>.</p>

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
- Other: 
    - JQuery, SASS, Blade templating, Bootstrap 

## Deployment for full environment
### Install Nginx
- sudo su
- apt update
- apt install nginx -y

### Install MySql Server
- apt install mysql-server -y
- mysql_secure_installation
	- answer prompts

### Alter root user permissions
	- mysql
	- ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
	- FLUSH PRIVILEGES;

### Install Default DB
    - CREATE DATABASE LookupApp;
    - exit
    
### Install PHP
- apt install software-properties-common -y
- add-apt-repository ppa:ondrej/php -y
- apt update
- apt install php7.4-fpm php7.4-mysql php7.4-common php7.4-mysql php7.4-xml php7.4-xmlrpc php7.4-curl php7.4-gd php7.4-imagick php7.4-cli php7.4-dev php7.4-imap php7.4-mbstring php7.4-opcache php7.4-soap php7.4-zip unzip -y

### Nginx Config
- nano /etc/nginx/sites-available/Lookup

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

- ln -s /etc/nginx/sites-available/Lookup /etc/nginx/sites-enabled/
- service nginx restart

### Install Laravel
- cd /var/www/html
- apt install git -y
- git clone https://github.com/jbrown1384/Lookup.git
- cd Lookup/
- chown -R www-data:www-data /var/www/html/Lookup/
- chmod -R 755 /var/www/html/Lookup/
- cp .env.example .env
- bash ./public/scripts/deploy.sh
    - Script will hault and wait for instruction during the "Install Faker Data" section. You can choose to install random generated customer data or import the schema and data with the supplied zipped sql file in public/data. To install manually through the data file, type exit and the deploy script will continue executing. To implement the faker generated customer data, type in the commands below in this order: 
    - factory(App\Address::class, 30)->create();
    - factory(App\Customer::class, 20)->create();
    - type exit to leave prompt. Deploy script will resume execution.

##  Data Import
- there are currently two options for importanting the test data for the application
### SQL Data File
    - The sql datafile is located in the public/data folder as a zip file. This contains all of the sql needed to create the schema as well as the test data to populate the tables
### Autogenerating Random Data
    - The application utilizes Faker for dynamically generating fake customer data and all many-to-many relationships.
    - The deploy script will load all dependancies, as well as initialize faker. During the executiion of the script a prompt will display as "Install Faker Data" and wait for a reply. You can type exit to skip the autogeneration of data or type the commands in the order below to execute: 
        - actory(App\Address::class, 30)->create();
        - factory(App\Customer::class, 20)->create();
        - type exit to leave prompt. Deploy script will resume execution. 
