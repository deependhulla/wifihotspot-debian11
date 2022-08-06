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
//if($_SERVER['HTTP_HOST']=="office.clubemerald.in" || $_SERVER['HTTP_HOST']=="clubemerald.duckdns.org" || $_SERVER['HTTP_HOST']=="im.clubemerald.in"  || $_SERVER['HTTP_HOST']=="192.168.1.254")
//{
//header('Location: http://office.clubemerald.in/cluboffice/');
//}
//else
//{
header('Location: http://192.168.223.254/wifilogin/');
//}
?>
