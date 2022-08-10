<?php

$mac=$_GET['getmac'];
$mac=str_replace("\n","",$mac);
$mac=str_replace("\t","",$mac);
$mac=str_replace("\r","",$mac);
$mac=str_replace("\0","",$mac);
$mac=str_replace(" ","",$mac);
$mac=str_replace(" ","",$mac);
if($mac!="")
{
$cmd='arp | grep -i "'.$mac.'" | cut -d " " -f 1';

$ipx=`$cmd`;
$ipx=str_replace("\n","",$ipx);
$ipx=str_replace("\r","",$ipx);
$ipx=str_replace("\t","",$ipx);
$ipx=str_replace("\0","",$ipx);
$ipx=str_replace(" ","",$ipx);
$ipx=str_replace(" ","",$ipx);
echo "MAC : ".$mac."\n";
echo "IP : ".$ipx."\n";
if($ipx!="")
{
$cmdx=" arpingweb -c 4 ".$ipx;
$pingx=`$cmdx`;
#echo "ARP-PING Response\n";
echo $pingx;
}
}

echo "";
?>
