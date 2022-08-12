<?php
include_once('dbinfo.php');
foreach($_REQUEST as $key=>$value)$$key=$value;
$limit=$length;
$srno=0;
if($start==""){$start=0;}
if($limit==""){$limit=15;}

$srno=$start+1;

$searchbox=$search['value'];
$orderby="";
$searchsql="";

if($searchbox!="")
{

$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `user_access_plan_name` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `validity_period_in_mins`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `access_plan_active`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";

}

###$mainsql="SELECT `uid`, `create_by_user`, `create_on_date`, `create_type`, `user_mac_address`, `user_full_name`, `user_mobile`, `user_email`, `user_membership_no`, `user_extra_office_info`, `user_access_plan`, `user_device_type`, `user_reg_browser_full_info`, `user_reg_browser`, `user_reg_device`, `user_reg_datetime`, `user_reg_active`, `user_activaton_datetime`, `user_mac_blocked`, `user_mobile_blocked`, `user_block_reason`, `user_block_datetime`, `user_internal_comments`, `user_ip_address` FROM `mac_user_info` where `user_mobile` like '%1234%'";

//$mainsql="SELECT `uid`, `sipexten`,`sipcallerid`, `sipnotes`, `sipeactive`,  `create_on_date` FROM `voip_sip_info` where 1";
$mainsql="SELECT `uid`, `user_access_plan_name`,`validity_period_in_mins`, `access_plan_active`, `traffic_limit_in_mb`, `traffic_reset_limit_in_mb`, `basic_download_max_speed_kbps`, `traffic_reset_period`, `plan_price` FROM `wifi_access_plan` WHERE 1";

$mysqlresult = $mysqldblink->query($mainsql);
$rtotal=0;
while($mysqlrow = $mysqlresult->fetch_array()){$rtotal++;
if($rtotal==1)
{
for($e=0;$e<sizeof($order);$e++)
{
$orderbycol="";$orderbycollast="";if($e!=0){$orderby=$orderby.", ";}$z=0;foreach($mysqlrow as $xaa => $xaa_value) {if($order[$e]['column'] == $xaa){$orderbycol=$orderbycollast;}$orderbycollast=$xaa;$z++;}
if($orderbycol!=""){
$orderby=$orderby." ".$orderbycol." ".$order[$e]['dir'];
}
}
}
}

#print "<Hr> $orderby<hr>";

$mainsql=$mainsql."  ".$searchsql;

$mysqlresult = $mysqldblink->query($mainsql);
$rstotal=0;
while($mysqlrow = $mysqlresult->fetch_array()){$rstotal++; }

if($orderby!="")
{
$mainsql=$mainsql." order by ".$orderby;
}
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

if($j==3 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="InActive";}
if($j==3 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="Active";}

if($j==4 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Unlimited";}
if($j==5 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="No Cap";}
if($j==6 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Unlimited";}
if($j==7 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Unlimited";}
//if($j==8 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="No Cap";}
if($j==8 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Free";}
print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>
