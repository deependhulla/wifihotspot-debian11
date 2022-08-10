<?
$ipAddress=$_SERVER['REMOTE_ADDR'];$macAddr=false;
$arp=`arp -a $ipAddress`;$lines=explode("\n", $arp);
foreach($lines as $line){
$cols=preg_split('/\s+/', trim($line));$cols[1]=str_replace("(","",$cols[1]);
$cols[1]=str_replace(")","",$cols[1]); if ($cols[1]==$ipAddress){$macAddr=$cols[3]; }
}
$ipx=array();
$ipx=explode(".",$ipAddress);
$ip3=$ipx[0].".".$ipx[1].".".$ipx[2];
//print "IP : $ipAddress MAC : $macAddr --> $ip3";
//print "<br> ".$_SERVER['SERVER_NAME'];
//print "<br> ".$_SERVER['SERVER_ADDR'];
//print "<br> ".$_SERVER['HTTP_HOST'];
if( $_SERVER['HTTP_HOST']=="office2.clubemerald.in" || $_SERVER['HTTP_HOST']=="office.clubemerald.in" || $_SERVER['HTTP_HOST']=="club.duckdns.org" || $_SERVER['HTTP_HOST']=="im.clubemerald.in"  || $_SERVER['HTTP_HOST']=="192.168.1.254")
{
header('Location: http://172.16.0.254/wifilogin/');
#header('Location: /cluboffice/');
}
else
{
header('Location: http://172.16.0.254/wifilogin/');
}
?>
