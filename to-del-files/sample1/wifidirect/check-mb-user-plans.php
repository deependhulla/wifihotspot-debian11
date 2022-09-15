<?
include_once('/var/www/html/wifilogin/dbconfig.php');
include_once('/var/www/html/wifilogin/checkusermb.php');
#$macAddr="B8:B4:2E:FE:85:93";
$macAddr=$argv[1];
#print "--> $macAddr";
$activembplan=1;
$dx=workmb();
print $dx;
?>
