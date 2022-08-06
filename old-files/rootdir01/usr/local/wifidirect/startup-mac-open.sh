#!/bin/sh
echo wifihotspot is getting register mac  with full access ON..like Printer.
/bin/cp /usr/local/webadmin/wifidirect/iptables /etc/sysconfig/
service iptables restart
echo 1 > /proc/sys/net/ipv4/ip_forward

/etc/init.d/htb.init restart

/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' https://127.0.0.1:8383/wifidirect/index.cgi?wifiupdate=yes >/tmp/a

