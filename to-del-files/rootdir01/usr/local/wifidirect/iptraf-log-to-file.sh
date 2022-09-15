#!/bin/sh
cd /usr/local/webadmin/wifidirect
ETHNAME=eth1
DATE_FILE=`date +"%Y-%m-%d-%H-%M-%S-%N"`
mkdir -p /var/log/iptraf-log/archive
mkdir -p /var/log/iptraf-log/live

kill -9 `ps x  | grep /usr/bin/iptraf | grep -v grep | cut -d " " -f 1` 2>/dev/null
kill -9 `ps x  | grep /usr/bin/iptraf | grep -v grep | cut -d " " -f 2` 2>/dev/null
mv /var/log/iptraf-log/live/*.log /var/log/iptraf-log/archive/ 2>/dev/null

/usr/bin/iptraf -f -B -i $ETHNAME -L /var/log/iptraf-log/live/iptraflog-$DATE_FILE.log 
PIDX=`ps x  | grep /usr/bin/iptraf | grep -v grep | sed -e 's/^[ \t]*//' |cut -d " " -f 1`
echo IpTraf Loggin Process running pid : $PIDX

