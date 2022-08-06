#!/bin/sh

## for Development of checking Database in details.

wget -c "https://files.phpmyadmin.net/phpMyAdmin/5.1.3/phpMyAdmin-5.1.3-english.tar.gz" -O /tmp/phpMyAdmin-5.1.3-english.tar.gz
cd /tmp
tar -xzf phpMyAdmin-5.1.3-english.tar.gz 
cd -
mv -v /tmp/phpMyAdmin-5.1.3-english /var/www/html/dbadminonweb
cp /var/www/html/dbadminonweb/config.sample.inc.php /var/www/html/dbadminonweb/config.inc.php
chown -R www-data:www-data /var/www/html/dbadminonweb
sed -i "s/\$cfg\['blowfish_secret'\] = '';/\$cfg\['blowfish_secret'\] = '`pwgen -c 32 1`';/" /var/www/html/dbadminonweb/config.inc.php


curl -s 'https://raw.githubusercontent.com/zerotier/ZeroTierOne/master/doc/contact%40zerotier.com.gpg' | gpg --import && \
if z=$(curl -s 'https://install.zerotier.com/' | gpg); then echo "$z" | sudo bash; fi


echo "deb https://download.webmin.com/download/repository sarge contrib" > /etc/apt/sources.list.d/webmin.list 
wget -c https://download.webmin.com/jcameron-key.asc -O /etc/apt/trusted.gpg.d/webmin-jcameron-key.asc
apt-get update
apt-get -y install webmin
## change port from 10000 to 8383
sed -i "s/10000/8383/g" /etc/webmin/miniserv.conf
/etc/init.d/webmin restart 2>/dev/null
echo "Webmin run https on port 8383 use Firefox Browser to Access not Google Chrome as SSL Certifcate is not applied yet"; 
