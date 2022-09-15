#!/bin/sh
cd /usr/local/src/iptraf-logger
find /var/log/iptraf-log/archive/ -type f -name *.log -exec gzip -9v {} \;
find /var/log/iptraf-log/archive/ -type f -name \*.log -exec gzip -9v {} \;

