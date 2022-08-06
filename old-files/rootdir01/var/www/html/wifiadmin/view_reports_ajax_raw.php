<?
include_once('dbinfo.php');
foreach($_REQUEST as $key=>$value)$$key=$value;
$limit=$length;
$srno=0;
//$rtype=$_GET['rtype'];
//$startdate=$_GET['startdate'];
//$enddate=$_GET['enddate'];

if($start==""){$start=0;}
if($limit==""){$limit=15;}

$srno=$start+1;

$searchbox=$search['value'];
$orderby="";
$searchsql="";

if($rtype=="userusage")
{
if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `avgbw` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `maxbw` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `avgdata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `maxdata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `totaldata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `max_date` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `min_date`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `user_mac`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_mobile`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_full_name`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";
}

$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$mainsql="SELECT  `user_mac`,`user_full_name`,`user_mobile`,`min_date`,`max_date`,`avgdata`,`maxdata`,`totaldata`,avgbw,maxbw,sumbw FROM ( 
SELECT  `user_mac`,`user_full_name`,`user_mobile`, MIN(`create_on_date`) as min_date, MAX(`create_on_date`) as max_date 
,ROUND(AVG( `iptables_bytes` )/(1024 * 1024),2) as avgdata ,ROUND(MAX( `iptables_bytes` )/(1024 * 1024),2) as maxdata,ROUND(SUM( `iptables_bytes` )/(1024 * 1024),2) as totaldata,

ROUND(((AVG( `iptables_bytes` )*8)/3600)/1024,2) as avgbw,
ROUND(((MAX( `iptables_bytes`)*8)/3600)/1024,2) as maxbw,
ROUND(((SUM( `iptables_bytes` )*8)/3600)/1024,2) as sumbw

FROM `wifilog`.`wifi_user_usage_".$startdatex."` WHERE  `user_mac` IN 
( SELECT  DISTINCT `user_mac` FROM `wifilog`.`wifi_user_usage_".$startdatex."` ) group by `user_mac` ) 
z WHERE 1 ";

}


/////////////////////////////////////////////////////
if($rtype=="macview")
{

$sqlx="SELECT `user_live_date` , `user_mac` FROM `wifi_daily_users` WHERE `user_mac` = '".$macid."'";
$xresult = $mysqldblink->query($sqlx);
$subsql="";
$si=0;
while($mrow = $xresult->fetch_array()){
if($si!=0){$subsql=$subsql." \n UNION \n ";}
$si++;
$startdate=$mrow[0];
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$subsql=$subsql."
SELECT  '".$startdate."' as userdate, `user_live_hour`,`user_full_name`,`user_mobile`,`min_date`,`max_date`,`avgdata`,`maxdata`,`totaldata`,avgbw,maxbw,sumbw FROM (
SELECT  `user_live_hour`,`user_mac`,`user_full_name`,`user_mobile`, MIN(`create_on_date`) as min_date, MAX(`create_on_date`) as max_date
,ROUND(AVG( `iptables_bytes` )/(1024 * 1024),2) as avgdata ,ROUND(MAX( `iptables_bytes` )/(1024 * 1024),2) as maxdata,ROUND(SUM( `iptables_bytes` )/(1024 * 1024),2) as totaldata,ROUND(((AVG( `iptables_bytes` )*8)/3600)/1024,2) as avgbw,ROUND(((MAX( `iptables_bytes`)*8)/3600)/1024,2) as maxbw,ROUND(((SUM( `iptables_bytes` )*8)/3600)/1024,2) as sumbw FROM `wifilog`.`wifi_user_usage_".$startdatex."` WHERE  `user_mac` = '".$macid."'   GROUP BY `user_live_hour`  )
zz ";

//while loop over for date wise query builder
}

#print "\n\n ".$subsql."  \n\n";


if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `user_live_hour` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `userdate` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `avgbw` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `maxbw` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `avgdata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `maxdata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `totaldata` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `max_date` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `min_date`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `user_mobile`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_full_name`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";
}



$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$mainsql="
SELECT  `userdate`,`user_live_hour`,`user_full_name`,`user_mobile`,`min_date`,`max_date`,`avgdata`,`maxdata`,`totaldata`,avgbw,maxbw,sumbw FROM (
".$subsql."
) az WHERE 1 
";
#print " \n $mainsql \n";
}



/////////////////////////////////////////////////////


if($rtype=="dailydata")
{
if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `user_live_date`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `iptables`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";
}

$mainsql="
select  `user_live_date`,`iptables` FROM (
SELECT `user_live_date`, ROUND( `iptables_bytes` /(1024 * 1024),2) as iptables FROM `wifi_daily_usage` 
 ) z 
 WHERE 1 ";

}






if($rtype=="usersactive")
{
if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `max_date` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `min_date`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `user_mac`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_mobile`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_full_name`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";
}

$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$mainsql="SELECT  `user_mac`,`user_full_name`,`user_mobile`,`min_date`,`max_date` FROM ( SELECT  `user_mac`,`user_full_name`,`user_mobile`, MIN(`create_on_date`) as min_date, MAX(`create_on_date`) as max_date FROM `wifilog`.`wifi_user_usage_".$startdatex."` WHERE  `user_mac` IN ( SELECT  DISTINCT `user_mac` FROM `wifilog`.`wifi_user_usage_".$startdatex."` ) group by `user_mac` ) z WHERE 1 ";
}


if($rtype=="userreg")
{
if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `activeuser` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `user_reg_datetime` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `user_mac_address`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_mobile`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_full_name`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";
}




$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$mainsql="
SELECT `user_mac_address` , `user_full_name` , `user_mobile` , `user_reg_datetime`,activeuser 
 FROM (
SELECT `user_mac_address` , `user_full_name` , `user_mobile` , `user_reg_datetime`,
(CASE WHEN `user_reg_active`= 1 THEN 'Verified' ELSE 'NotVerified' END) activeuser
FROM `mac_user_info`
) z 

WHERE 1 ";
}


$mysqlresult = $mysqldblink->query($mainsql);
$rtotal=0;
while($mysqlrow = $mysqlresult->fetch_array()){$rtotal++;
if($rtotal==1)
{
for($e=0;$e<sizeof($order);$e++)
{
$orderbycol="";$orderbycollast="";if($e!=0){$orderby=$orderby.", ";}$z=0;
foreach($mysqlrow as $xaa => $xaa_value) {

#print "".$order[$e]['column']." == ".$xaa."<hr>";
if(($order[$e]['column']) == $xaa){
#print "".$order[$e]['column']." == ".$xaa."<hr>";
$orderbycol=$orderbycollast;
}
$orderbycollast=$xaa;
$z++;
}

if($orderbycol=="" && $order[$e]['column'] !=""){$orderbycol=$orderbycollast;}
if($orderbycol!=""){
$orderby=$orderby." ".$orderbycol." ".$order[$e]['dir'];
}
}
}
}

#print "<Hr> $orderby<hr>";

$mainsql=$mainsql."  ".$searchsql;
#print "\n $mainsql\n";
$mysqlresult = $mysqldblink->query($mainsql);
$rstotal=0;
while($mysqlrow = $mysqlresult->fetch_array()){$rstotal++; }
if($orderby =="" && $rtype=="macview")
{
$orderby=" userdate,user_live_hour ";
}


if($orderby!="")
{
$mainsql=$mainsql." order by ".$orderby;
}

#print "\n $mainsql\n";
//$mysqlresult = $mysqldblink->query($mainsql);
//$rtotal=0;
//while($mysqlrow = $mysqlresult->fetch_array()){$rtotal++;}






#print " Search --> $searchbox";
print '{"draw":'.$draw.',"recordsTotal":"'.$rtotal.'","recordsFiltered":"'.$rstotal.'","data":[';


$sqlxdata=$mainsql. " limit $start,$limit";

#print "<hr>$sqlxdata<hr>\n";
#exit;
$mysqlresult = $mysqldblink->query($sqlxdata);
$i=0;
while($mysqlrow = $mysqlresult->fetch_array()){
$i++;
if($i!=1){print ",";}
print "[";
for($j=0;$j<sizeof($mysqlrow);$j++)
{
if($j==0){print "\"".$srno."\","; $srno++;}
if($j!=0){print ",";}

#if($j==3 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="InActive";}
#if($j==3 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="Active";}
print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>
