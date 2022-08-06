#!/bin/bash

##disable ipv6 as most time not required
## also while installation at time ipv6 is not ready at your setup
sysctl -w net.ipv6.conf.all.disable_ipv6=1 1>/dev/null
sysctl -w net.ipv6.conf.default.disable_ipv6=1 1>/dev/null

## set to India IST timezone -- You can change this based on some other country.
timedatectl set-timezone 'Asia/Kolkata'
systemctl restart rsyslog 


## backup existing repo by copy just for safety
/bin/cp -pR /etc/apt/sources.list /usr/local/src/old-sources.list-`date +%s`
echo "" >  /etc/apt/sources.list
echo "deb http://deb.debian.org/debian bullseye main contrib non-free" >> /etc/apt/sources.list
echo "deb http://deb.debian.org/debian bullseye-updates main contrib non-free" >> /etc/apt/sources.list
echo "deb http://security.debian.org/debian-security bullseye-security main contrib non-free" >> /etc/apt/sources.list


### postfix instead of exim for ststem alert mail config if any
CFG_HOSTNAME_FQDN=`hostname -f`
echo "postfix postfix/main_mailer_type select Internet Site" | debconf-set-selections
echo "postfix postfix/mailname string $CFG_HOSTNAME_FQDN" | debconf-set-selections
echo "iptables-persistent iptables-persistent/autosave_v4 boolean true" | debconf-set-selections
echo "iptables-persistent iptables-persistent/autosave_v6 boolean true" | debconf-set-selections

apt-get update
apt-get -y upgrade
apt-get -y install vim curl git software-properties-common dirmngr screen mc apt-transport-https lsb-release ca-certificates openssh-server iptraf-ng telnet iputils-ping debconf-utils pwgen xfsprogs iftop htop multitail net-tools elinks wget  mariadb-server php apache2 libapache2-mod-php php-mysql php-cli php-common php-imap php-ldap php-xml php-curl php-mbstring php-zip php-apcu php-gd php-imagick imagemagick mcrypt memcached php-memcached php-bcmath dbconfig-common libapache2-mod-php php-intl php-mysql php-intl libdbd-mysql-perl certbot python3-certbot-apache automysqlbackup php-mailparse postfix iptables-persistent libimage-exiftool-perl build-essential gnupg2 zip rar unrar ftp poppler-utils tnef sudo whois libauthen-pam-perl libio-pty-perl libnet-ssleay-perl perl-openssl-defaults sendemail rsync mariadb-server perl-doc mysqltuner catdoc unzip tar imagemagick tesseract-ocr tesseract-ocr-eng poppler-utils exiv2 php-mail-mime 
## to use more advance database storage type


## install insstead of systemd-timesyncd for better time sync
apt-get install chrony -y 2>/dev/null 1>/dev/null
## -x option added to allow in LXC too
echo 'DAEMON_OPTS="-F 1 -x "' >  /etc/default/chrony
systemctl restart chrony
systemctl restart rsyslog


a2enmod actions > /dev/null 2>&1
a2enmod proxy_fcgi > /dev/null 2>&1
a2enmod fcgid > /dev/null 2>&1
a2enmod alias > /dev/null 2>&1
a2enmod suexec > /dev/null 2>&1
a2enmod rewrite > /dev/null 2>&1
a2enmod ssl > /dev/null 2>&1
a2enmod actions > /dev/null 2>&1
a2enmod include > /dev/null 2>&1
a2enmod dav_fs > /dev/null 2>&1
a2enmod dav > /dev/null 2>&1
a2enmod auth_digest > /dev/null 2>&1
a2enmod cgi > /dev/null 2>&1
a2enmod headers > /dev/null 2>&1
a2enmod proxy_http > /dev/null 2>&1

## keep fpm disabled default if installed by mistake
systemctl stop php.fpm  > /dev/null 2>&1
systemctl disable php-fpm > /dev/null 2>&1

##### configure proper timezone
#dpkg-reconfigure tzdata
##### configure locale proper
#dpkg-reconfigure locales

#### for adding firmware realtek driver
#apt-get install firmware-linux-nonfree
#apt-get install firmware-realtek
#update-initramfs -u
## only if VM notfor LXC
## for proxmox/kvm better preformance
#apt-get -y install qemu-guest-agent
## if on Consle need Mouse to use for copy paste use gpm
#apt-get install gpm

#hostname -f
#ping `hostname -f` -c 2



