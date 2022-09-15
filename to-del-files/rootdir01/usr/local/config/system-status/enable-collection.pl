#!/usr/bin/perl
open(CONF, "/usr/local/webadmin/config/miniserv.conf") || die "Failed to open /usr/local/webadmin/config/miniserv.conf : $!";
while(<CONF>) {
        $root = $1 if (/^root=(.*)/);
        }
close(CONF);
$root || die "No root= line found in /usr/local/webadmin/config/miniserv.conf";
$ENV{'PERLLIB'} = "$root";
$ENV{'WEBMIN_CONFIG'} = "/usr/local/webadmin/config";
$ENV{'WEBMIN_VAR'} = "/usr/local/webadmin/pidfiles";
chdir("$root/system-status");
exec("$root/system-status/enable-collection.pl", @ARGV) || die "Failed to run $root/system-status/enable-collection.pl : $!";
