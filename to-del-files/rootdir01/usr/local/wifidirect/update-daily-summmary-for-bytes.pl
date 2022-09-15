#!/usr/bin/perl
use DBI;
use POSIX qw(strftime);
use Time::Local;
use POSIX;
#$now_string = strftime "%a %b %e %H:%M:%S %Y", localtime;
$now_string = strftime "%a-%d-%m-%Y-%H-%M-%S", localtime;
($dayx,$datex,$monx,$yearx,$hourx,$minx,$secx)=split/-/,$now_string;
$todayx=$yearx."-".$monx."-".$datex;
$dbname="wifihotspot";
$hostname="localhost";
$username="root";
$password="techno02srv";

$yes_string = strftime "%a-%d-%m-%Y-%H-%M-%S", localtime(time-86400);
($ydayx,$ydatex,$ymonx,$yyearx,$yhourx,$yminx,$ysecx)=split/-/,$yes_string;
$yesdayx=$yyearx."-".$ymonx."-".$ydatex;


$dbh=DBI->connect("dbi:mysql:$dbname:$hostname",$username,$password) or die("cannot connect to wifihotshot database");


sub workfordate
{
my @gargv = @_;
$gdatey=@gargv[0];
($gyearx,$gmonx,$gdatex)=split/-/,$gdatey;
$gottoday=0;
$sqlx="SELECT  `iptables_bytes`   FROM `wifi_daily_usage` WHERE `user_live_date`='".$gdatey."'; ";
#print " \n $sqlx \n";
$sth=$dbh->prepare($sqlx);
$sth->execute();
while(@yarows=$sth->fetchrow_array()){
$gottoday=1;
}
if($gottoday==0)
{
$sqlz="INSERT INTO `wifi_daily_usage` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `user_live_date`, `iptables_packets`, `iptables_bytes`) VALUES (NULL, NULL, '', NOW(), '', '".$gdatey."', '0', '0');";
$sth=$dbh->prepare($sqlz);
$sth->execute();
#print " \n $sqlz \n";

}

$outx=0;
$sqlx="UPDATE `wifi_daily_usage` SET `iptables_bytes` = (SELECT SUM( `iptables_bytes` )  FROM `wifilog`.`wifi_user_usage_".$gyearx."_".$gmonx."_".$gdatex."`) where  `user_live_date`='".$gdatey."'; ";
#print " \n $sqlx \n";
$sth=$dbh->prepare($sqlx);
$sth->execute();

$sqlx="INSERT IGNORE `wifihotspot`.`wifi_daily_users` (`user_live_date` , `user_mac` ) SELECT DISTINCT `user_live_full_date`, `user_mac` FROM `wifilog`.`wifi_user_usage_".$gyearx."_".$gmonx."_".$gdatex."`";
$sth=$dbh->prepare($sqlx);
$sth->execute();
print "\n Done for $gdatey";





}
### sub routine function over.

&workfordate($yesdayx);
&workfordate($todayx);
