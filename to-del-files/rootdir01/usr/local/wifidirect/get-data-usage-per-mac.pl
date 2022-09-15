#!/usr/bin/perl

$dbname="wifihotspot";
$hostname="localhost";
$username="root";
$password="techno02srv";

$macdel=$ARGV[0];
$macdel=~ s/\n//eg;
$macdel=~ s/\r//eg;
$macdel=~ s/\t//eg;
$macdel=~ s/ //eg;
$macdel=uc($macdel);
$usermac=$macdel;
if($macdel ne "")
{
$usermacx=$usermac;
$usermacx=~ s/://eg;
$cmdx="/sbin/iptables  -nvxL M-".$usermacx." | sed 's/\t/ /g' | sed 's/  / /g' |  sed 's/  / /g'  | sed 's/  / /g'  |  sed 's/  / /g' | sed 's/  / /g' | sed 's/ /|/g' | cut -d \"|\"  -f 1,2,3,7,8,12";
#print "\n $cmdx \n";
@cmdxz=();
@cmdxz=`$cmdx`;
$userpacket=0;
$userbytes=0;
$cmdzz="/sbin/iptables -Z M-".$usermacx." ";
print "\n $cmdzz \n";
$cmdzzzz=`$cmdzz`;

for($ex=2;$ex<@cmdxz;$ex++)
{
$cmdxx=$cmdxz[$ex];
$cmdxx=~ s/\t//eg;
$cmdxx=~ s/\n//eg;
$cmdxx=~ s/\r//eg;
$cmdxx=~ s/ //eg;
@datax=();
@datax=split/\|/,$cmdxx;
$userpacket=$userpacket+$datax[1];
$userbytes=$userbytes+$datax[2];
$userip=$datax[4];
#print "\n --> ".$ex." --> ".$cmdxx." DDD \n";
}

print "IP : ".$userip." MAC  : ".$usermac."--> Packet $userpacket Bytes --> $userbytes \n";
### if userbytes >0
if($userbytes>0)
{

use DBI;

use POSIX qw(strftime);
#$now_string = strftime "%a %b %e %H:%M:%S %Y", localtime;
$now_string = strftime "%a-%d-%m-%Y-%H-%M-%S", localtime;
#print "$now_string";
($dayx,$datex,$monx,$yearx,$hourx,$minx,$secx)=split/-/,$now_string;
$dbh=DBI->connect("dbi:mysql:$dbname:$hostname",$username,$password) or die("cannot connect to wifihotshot database");

$getuserinfosql="SELECT `uid` , `create_by_user` , `create_on_date` , `create_type` , `user_mac_address` , `user_full_name` , `user_mobile` , `user_email` , `user_membership_no` , `user_extra_office_info` , `user_access_plan` , `user_device_type` , `user_reg_browser_full_info` , `user_reg_browser` , `user_reg_device` , `user_reg_datetime` , `user_reg_active` , `user_activaton_datetime` , `user_mac_blocked` , `user_mobile_blocked` , `user_block_reason` , `user_block_datetime` , `user_internal_comments` , `user_ip_address` FROM `mac_user_info` WHERE `user_mac_address` = '".$usermac."'";
$force_deactive=0;
#print "\n $getuserinfosql \n";

$sth=$dbh->prepare($getuserinfosql);
$sth->execute();
while(@yarows=$sth->fetchrow_array()){
$macuserid=$yarows[0];
$usermobile=$yarows[6];
$user_email=$yarows[7];
$user_full_name=$yarows[5];
$user_device_type=$yarows[11];
$user_reg_browser_full_info=$yarows[12];
$user_reg_browser=$yarows[13];
$user_reg_device=$yarows[14];
$user_reg_datetime=$yarows[15];
print "\n  16 ".$yarows[16]."\n";
print "\n  18 ".$yarows[18]."\n";
print "\n  19 ".$yarows[19]."\n";
if($yarows[16] eq "0"){$force_deactive=1;}
if($yarows[18] eq "1"){$force_deactive=1;}
if($yarows[19] eq "1"){$force_deactive=1;}
}
print "\n force_act : $force_deactive \n";

$tablex=" wifilog.`wifi_user_usage_".$yearx."_".$monx."_".$datex."` ";
$createsql="CREATE TABLE IF NOT EXISTS ".$tablex." (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `user_live_full_date` date NOT NULL,
  `user_live_date` int(11) NOT NULL,
  `user_live_day` varchar(4) NOT NULL,
  `user_live_mon` int(11) NOT NULL,
  `user_live_year` int(11) NOT NULL,
  `user_live_hour` int(11) NOT NULL,
  `user_live_min` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_mobile` varchar(250) NOT NULL DEFAULT '',
  `user_mac` varchar(250) NOT NULL DEFAULT '',
  `user_ip` varchar(250) NOT NULL DEFAULT '',
  `user_eth` varchar(5) NOT NULL,
  `iptables_packets` bigint(11) NOT NULL DEFAULT '0',
  `iptables_bytes` bigint(11) NOT NULL DEFAULT '0',
  `modem_location_id` int(11) NOT NULL DEFAULT '0',
  `user_full_name` varchar(250) NOT NULL,
  `user_device_type` varchar(250) NOT NULL,
  `user_reg_browser_full_info` varchar(250) NOT NULL,
  `user_reg_browser` varchar(250) NOT NULL,
  `user_reg_device` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_reg_datetime` datetime NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `user_mac` (`user_mac`),
  KEY `iptables_packets` (`iptables_packets`),
  KEY `iptables_bytes` (`iptables_bytes`),
  KEY `user_id` (`user_id`),
  KEY `user_live_mon` (`user_live_mon`),
  KEY `user_live_year` (`user_live_year`),
  KEY `user_live_hour` (`user_live_hour`),
  KEY `user_live_min` (`user_live_min`),
  KEY `modem_location_id` (`modem_location_id`),
  KEY `user_live_full_date` (`user_live_full_date`),
  KEY `user_live_date` (`user_live_date`),
  KEY `user_live_day` (`user_live_day`),
  KEY `user_eth` (`user_eth`),
  KEY `user_mobile` (`user_mobile`)
) ENGINE=TokuDB DEFAULT CHARSET=latin1 `compression`='tokudb_zlib' AUTO_INCREMENT=1 ;";

#####) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

print "\n $createsql \n";
$sth=$dbh->prepare($createsql);
$sth->execute();

$sqlin="INSERT INTO ".$tablex." (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `user_live_full_date`,`user_live_date`, `user_live_day`, `user_live_mon`, `user_live_year`, `user_live_hour`, `user_live_min`, `user_id`, `user_mobile`, `user_mac`, `user_ip`, `iptables_packets`, `iptables_bytes`, `modem_location_id`,`user_eth`,`user_full_name`,`user_device_type`,`user_reg_browser_full_info`,`user_reg_browser`,`user_reg_device`,`user_email`,`user_reg_datetime` ) VALUES (NULL, NULL, 'auto', NOW(), 'new', NOW(), '".$datex."','".$dayx."', '".$monx."', '".$yearx."', '".$hourx."', '".$minx."', '".$macuserid."', '".$usermobile."', '".$usermac."', '".$userip."', '".$userpacket."', '".$userbytes."', '".$usermodemid."','".$usereth."','".$user_full_name."','".$user_device_type."','".$user_reg_browser_full_info."','".$user_reg_browser."','".$user_reg_device."','".$user_email."','".$user_reg_datetime."');";

$sth=$dbh->prepare($sqlin);
$sth->execute();

#print "\nwork for insert\n";
print " $sqlin \n";


##### work for plan over --start
$notactive=1;
$sqlx1="SELECT `uid`, `mac_uid`, `plan_uid`,  `start_time`, `end_time`, `access_plan_live` FROM `wifi_live_plans` WHERE `mac_uid` = ".$macuserid."  and `end_time`>NOW() and `uid` in (SELECT `uid` FROM ( ( SELECT `uid`  FROM `wifi_live_plans`  WHERE `mac_uid` = ".$macuserid." ORDER BY `uid` DESC LIMIT 0,1) z ) )";
print "\n$sqlx1\n";
$sth=$dbh->prepare($sqlx1);
$sth->execute();
while(@yarows=$sth->fetchrow_array()){$notactive=0;}
if($force_deactive==1){$notactive=1; print "FORCE";}
$cmz="/usr/bin/php /usr/local/webadmin/wifidirect/check-mb-user-plans.php ".$usermac;
$ddx=`$cmz`;
print "\n $cmz -->$ddx<-- \n";
if($ddx==0){$notactive=1;}
if($ddx==2){$notactive=1;}
if($notactive==1)
{
$cmdx="/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' \"https://127.0.0.1:8383/wifidirect/index.cgi?macx=".$usermac."&macipx=".$userip."&activenow=0&\"";
print "\n $cmdx \n";
`$cmdx`;
}
##### work for plan over --end


### work for userbytes more than zero
}



## check mac input over 
}



