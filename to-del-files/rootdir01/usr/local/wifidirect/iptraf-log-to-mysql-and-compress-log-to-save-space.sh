#!/bin/sh
cd /usr/local/webadmin/wifidirect
find /var/log/iptraf-log/archive/ -type f -name *.log -exec /usr/local/webadmin/wifidirect/log-into-mysql-per-file-and-compress.sh {} \;
find /var/log/iptraf-log/archive/ -type f -name \*.log -exec /usr/local/webadmin/wifidirect/log-into-mysql-per-file-and-compress.sh {} \;

