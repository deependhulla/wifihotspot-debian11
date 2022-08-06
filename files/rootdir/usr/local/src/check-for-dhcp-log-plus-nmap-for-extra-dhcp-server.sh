#!/bin/sh

cat /var/log/syslog | grep dhcp | grep wrong

echo  nmap --script broadcast-dhcp-discover -e eth0

nmap --script broadcast-dhcp-discover -e eth0
