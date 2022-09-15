<?php
include_once('dbconfig.php');
#$macAddr="B8:B4:2E:FE:85:93";
#$activembplan=1;
function workmb()
{
$debugx=0;
global $activembplan;
global $macAddr;
global $mysqldblink;
if($debugx==1){print "MAC: $macAddr\n";}
$reasonx="";
$gotmid=0;
$sqlxz = "SELECT `uid`,`user_reg_active`,`user_mobile`,`user_mac_blocked`,`user_mobile_blocked`,`user_access_plan`, Date_Format( `user_reg_datetime`, '%Y-%m-%d' ) as regdate   FROM `mac_user_info` where `user_mac_address`='".$macAddr."' order by uid DESC limit 0 ,1";
#print $sqlxz;
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
#print_r($mysqlrow);
$gotmid=$mysqlrow['uid'];
}
if($gotmid>0)
{
$startdatex="";
$startdatetimex="";
$enddatex="";
$stotalmb=0;
$sresettime=0;
$sresetmb=0;
$gtotalmb=0;
$gresettime=0;
$gresetmb=0;


#print "\n $gotmid \n";
$sqlx1="SELECT `uid`, `mac_uid`, `plan_uid`,`start_time`,  Date_Format(`start_time`, '%Y-%m-%d' ) as startdate, Date_Format(`end_time`, '%Y-%m-%d' ) as enddate, `access_plan_live`,`traffic_limit_in_mb`,`traffic_reset_period`,`traffic_reset_limit_in_mb` FROM `wifi_live_plans` WHERE `mac_uid` = ".$gotmid."  and `end_time`>NOW() and `uid` in (SELECT `uid` FROM ( ( SELECT `uid`  FROM `wifi_live_plans`  WHERE `mac_uid` = ".$gotmid." ORDER BY `uid` DESC LIMIT 0,1 ) z ) )";
#print "$sqlx1 <hr>";
$expiretime="";
$tmysqlresult = $mysqldblink->query($sqlx1);
while($tmysqlrow = $tmysqlresult->fetch_assoc())
{
$stotalmb=$tmysqlrow['traffic_limit_in_mb'] * 1000000;
$sresettime=$tmysqlrow['traffic_reset_period'];
$sresetmb=$tmysqlrow['traffic_reset_limit_in_mb'] * 1000000;
$startdatex=$tmysqlrow['startdate'];
$startdatetimex=$tmysqlrow['start_time'];
$enddatex=$tmysqlrow['enddate'];
if($debugx==1){
print "LIVEUID ".$tmysqlrow['uid']."\n";
print "START DATE ".$tmysqlrow['startdate']."\n";
print "START TIME ".$tmysqlrow['start_time']."\n";
print "END DATE ".$tmysqlrow['enddate']."\n";
print "TOTAL MB ".$stotalmb."\n";
print "RATE DAY ".$sresettime."\n";
print "RATE MB ".$sresetmb."\n";
}
}
// Got active plan information over
if($stotalmb==0){$stotalmb=10000000000000000000;}
//Check total mb is over or not --start
if($stotalmb>0)
{
$dayarray=array();
$d=0;
$sqlx="SELECT `user_live_date` , `user_mac` FROM `wifi_daily_users` WHERE `user_live_date` >= '".$startdatex."' AND `user_mac` LIKE '".$macAddr."' ORDER BY `wifi_daily_users`.`user_live_date` ASC ";
#print "\n $sqlx \n";
$tmysqlresult = $mysqldblink->query($sqlx);
while($tmysqlrow = $tmysqlresult->fetch_assoc())
{
$dayarray[$d]=$tmysqlrow['user_live_date'];
$d++;
}
//Check total mb is over or not -- end
}
// Check for each day record
for($d=0;$d<sizeof($dayarray);$d++)
{
$tablex=str_replace("-","_",$dayarray[$d]);
if($debugx==1){
print "Work for Day: ".$dayarray[$d]."\n";
}
$sqlx="SELECT SUM(`iptables_bytes`) as totalbytes FROM `wifilog`.`wifi_user_usage_".$tablex."` WHERE `create_on_date` >= '".$startdatetimex."' AND `user_mac` LIKE '".$macAddr."' ORDER BY `create_on_date` ASC";
#print "$sqlx <br>\n";
$dailybytes=0;
$tmysqlresult = $mysqldblink->query($sqlx);
while($tmysqlrow = $tmysqlresult->fetch_assoc())
{
$dailybytes=$tmysqlrow['totalbytes'];
}
$gtotalmb=$gtotalmb + $dailybytes;
if($gresettime==0){$gresetmb=0;}
$gresettime++;
$gresetmb=$gresetmb + $dailybytes;
if($debugx==1){
print "<br>DAILY : $dailybytes : Total : $gtotalmb  --> $sresettime >  $sresetmb --> $gresettime --> $gresetmb\n";
}
if($activembplan==1 && $gtotalmb > $stotalmb){ $activembplan=0; $reasonx="Total Allocated Used";}
// work for rest limit start
if($activembplan==1 && $sresettime > 0 && $sresetmb > 0){ 
if($sresettime == $gresettime ){$gresettime=0;}
if($debugx==1){print "\n work for every day \n ";}
// work for rest limit end
}
// For loop for Day check over
}

$lastdaycheckwas=$dayarray[sizeof($dayarray)-1];
$todaycheck=date("Y-m-d");
if($lastdaycheckwas != $todaycheck)
{
$gresetmb=0;
#print "REST NOW day";
}
#print " -->".$lastdaycheckwas."-->".$todaycheck;

if($activembplan==1 && $sresettime > 0 && $sresetmb > 0){
if($debugx==1){ print "\n  Action for REST rules\n ";}
if( $gresetmb > $sresetmb){ $activembplan=2; $reasonx="Allocated for Day Period used.";}
}
// got mac id --over
}
// Function over here
if($debugx==1){ print "\nACTIVE MB PLAN : $activembplan : $reasonx\n";}
#print "---> $activembplan";
return $activembplan;
}

#workmb();

?>
