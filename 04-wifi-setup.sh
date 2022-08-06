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


