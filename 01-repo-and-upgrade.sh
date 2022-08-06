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

apt-get update
apt-get -y upgrade
apt-get -y install vim curl git software-properties-common dirmngr screen mc apt-transport-https lsb-release ca-certificates openssh-server iptraf-ng telnet iputils-ping debconf-utils pwgen xfsprogs iftop htop multitail net-tools elinks wget  mariadb-server php apache2 libapache2-mod-php php-mysql php-cli php-common php-imap php-ldap php-xml php-curl php-mbstring php-zip php-apcu php-gd php-imagick imagemagick mcrypt memcached php-memcached php-bcmath dbconfig-common libapache2-mod-php php-intl php-mysql php-intl libdbd-mysql-perl certbot python3-certbot-apache automysqlbackup php-mailparse 

##### configure proper timezone
#dpkg-reconfigure tzdata
##### configure locale proper
#dpkg-reconfigure locales
## set India IST time.
#/bin/rm -rf /etc/localtime
#/bin/ln -vs /usr/share/zoneinfo/Asia/Kolkata /etc/localtime
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



