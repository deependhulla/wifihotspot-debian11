#!/bin/bash

echo "Building WIFI DB ...please wait..."
echo "192.168.223.254 login.techoair.in login" >> /etc/hosts

#echo never > /sys/kernel/mm/transparent_hugepage/enabled
#echo never > /sys/kernel/mm/transparent_hugepage/defrag
ulimit -H -n 50000  1>/dev/null 2>/dev/null
ulimit -S -n 40000  1>/dev/null 2>/dev/null
sysctl -w net.core.netdev_max_backlog=4096  1>/dev/null 2>/dev/null
sysctl -w net.core.somaxconn=4096 1>/dev/null 2>/dev/null
sysctl -w net.ipv4.tcp_max_syn_backlog=4096  1>/dev/null 2>/dev/null

mysql < files/mysql-db.sql  1>/dev/null 2>/dev/null
mysql wifihotspot < files/wifihotspot.sql  1>/dev/null 2>/dev/null
mysql wifi_iptraf < files/iptraf.sql  1>/dev/null 2>/dev/null
chown -R www-data:www-data /var/www/html/
## copy all default config files
/bin/cp -pRv files/rootdir/* /
systemctl disable unbound
systemctl stop unbound
systemctl start named
systemctl enable named



### changing timezone to Asia Kolkata
sed -i "s/;date.timezone =/date\.timezone \= \'Asia\/Kolkata\'/" /etc/php/7.4/apache2/php.ini
sed -i "s/;date.timezone =/date\.timezone \= \'Asia\/Kolkata\'/" /etc/php/7.4/cli/php.ini
sed -i "s/;date.timezone =/date\.timezone \= \'Asia\/Kolkata\'/" /etc/php/7.4/fpm/php.ini
##disable error
sed -i "s/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ERROR/" /etc/php/7.4/cli/php.ini
sed -i "s/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ERROR/" /etc/php/7.4/fpm/php.ini
sed -i "s/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ERROR/" /etc/php/7.4/apache2/php.ini

sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/apache2/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/cli/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.4/fpm/php.ini

sed -i "s/Geng0yoo/`cat /usr/local/src/mariadb-mydbadmin-pass`/" /var/www/html/wifiadmin/dbinfo.php
sed -i "s/Geng0yoo/`cat /usr/local/src/mariadb-mydbadmin-pass`/" /var/www/html/wifilogin/dbconfig.php

sed -i "s/Geng0yoo/`cat /usr/local/src/mariadb-mydbadmin-pass`/" /usr/share/webmin/wifidirect/index.cgi 
sed -i "s/Geng0yoo/`cat /usr/local/src/mariadb-mydbadmin-pass`/" /usr/share/webmin/wifidirect/get-data-usage-per-mac.pl
sed -i "s/Geng0yoo/`cat /usr/local/src/mariadb-mydbadmin-pass`/" /usr/share/webmin/wifidirect/update-daily-summmary-for-bytes.pl 

ln -vs /usr/share/webmin /usr/local/webadmin


systemctl enable isc-dhcp-server.service
systemctl restart isc-dhcp-server.service

echo " Done.";
echo "";
