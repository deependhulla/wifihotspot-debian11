#!/bin/sh

#/bin/cp -pR rootdir01/* /

echo "192.168.223.254 login.techoair.in login" >> /etc/hosts

echo never > /sys/kernel/mm/transparent_hugepage/enabled
echo never > /sys/kernel/mm/transparent_hugepage/defrag
echo -n ..
ulimit -H -n 50000  1>/dev/null 2>/dev/null
ulimit -S -n 40000  1>/dev/null 2>/dev/null
sysctl -w net.core.netdev_max_backlog=4096  1>/dev/null 2>/dev/null
sysctl -w net.core.somaxconn=4096 1>/dev/null 2>/dev/null
sysctl -w net.ipv4.tcp_max_syn_backlog=4096  1>/dev/null 2>/dev/null

mysql -ptechno02srv < mysql-db.sql
mysql -ptechno02srv wifihotspot < wifihotspot.sql
mysql -ptechno02srv mysar < mysar.sql
mysql -ptechno02srv wifi_iptraf < iptraf.sql

## force one time backup for Testing
/usr/local/bin/automysqlbackup 1>/dev/null 2>/dev/null

/bin/sendEmail -f root@`hostname` -t sysalert@technoinfotech.com -u 'TechnoAir '`hostname`' Server Installed' -o message-file=/root/install.log
#/bin/healthreportonemail sysalert@technoinfotech.com



## plan for Mysar setup and squid/dhcpd/dhs/httpd for pac and transpaent
echo -n ..
#clear
echo
echo
echo Please make sure hostname is there in /etc/hosts for both lan card IPs
echo After /etc/hosts checked , Please REBOOT the server to start all services.
