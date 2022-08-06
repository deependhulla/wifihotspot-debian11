#!/bin/sh

/etc/init.d/isc-dhcp-server restart

/etc/init.d/apache2 restart
