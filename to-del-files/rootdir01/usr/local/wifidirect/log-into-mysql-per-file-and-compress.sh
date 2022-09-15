#!/bin/sh
LOG_File=$1
echo "Log file location = $LOG_File"
/bin/sed 's/\;\{1,\}//g' $LOG_File | sed 's/\,\{1,\}//g' | sed 's/:/ /g'| sed s/\ \ */\,/g >/tmp/wifi_iptraf.log
mysql -ptechno02srv wifi_iptraf < /usr/local/webadmin/wifidirect/wifi-iptraf.sql
echo "data inserted to mysql for $1"
echo now compressing
gzip -9v $1
echo done.
