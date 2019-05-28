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

## Instal MySQL server ##

    sudo apt-get --assume-yes install mysql-server

### Setup secure installation ###

    sudo mysql_secure_installation

### Update ###

    

### Update ###

    

### Update ###

    
