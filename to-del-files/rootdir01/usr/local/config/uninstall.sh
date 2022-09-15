#!/bin/sh
printf "Are you sure you want to uninstall Webmin? (y/n) : "
read answer
printf "\n"
if [ "$answer" = "y" ]; then
	/usr/local/webadmin/config/stop
	echo "Running uninstall scripts .."
	(cd "/usr/local/webadmin" ; WEBMIN_CONFIG=/usr/local/webadmin/config WEBMIN_VAR=/usr/local/webadmin/pidfiles LANG= "/usr/local/webadmin/run-uninstalls.pl")
	echo "Deleting /usr/local/webadmin .."
	rm -rf "/usr/local/webadmin"
	echo "Deleting /usr/local/webadmin/config .."
	rm -rf "/usr/local/webadmin/config"
	echo "Done!"
fi
