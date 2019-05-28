## Ubuntu installation for Laravel ##

### Update Ubuntu ###

    sudo apt --assume-yes update && apt upgrade

###  Software-properties-common package to get add-apt-repository command ###
    
    sudo apt-get install -y software-properties-common

### Install Midnight Commander ###

    sudo apt-get --assume-yes install mc

### Install expect necessary for secure mysql installation later ###

    sudo apt-get install expect -y

## Install Apache web server ##

    sudo apt --assume-yes install apache2

### Start Apache service ###

    sudo systemctl start apache2

### Enable Apache server to always startup when the server boots up ###

    sudo systemctl enable apache2

## Install MySQL Server ##

    sudo apt-get --assume-yes install mysql-server

### Setup secure installation ###

    sudo mysql_secure_installation

## Install PHP ##

    sudo apt install php libapache2-mod-php php-common php-mbstring php-xmlrpc php-soap php-gd php-xml php-mysql php-cli php-mcrypt php-zip -y    

## Composer ##

    cd ~
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    HASH=544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    
To test the installation run:
    composer

### Update ###

    
