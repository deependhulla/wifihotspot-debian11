<?
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
$searchsql=$searchsql." `uid` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `user_email` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `user_mac_address`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `user_mobile`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_full_name`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";

}

###$mainsql="SELECT `uid`, `create_by_user`, `create_on_date`, `create_type`, `user_mac_address`, `user_full_name`, `user_mobile`, `user_email`, `user_membership_no`, `user_extra_office_info`, `user_access_plan`, `user_device_type`, `user_reg_browser_full_info`, `user_reg_browser`, `user_reg_device`, `user_reg_datetime`, `user_reg_active`, `user_activaton_datetime`, `user_mac_blocked`, `user_mobile_blocked`, `user_block_reason`, `user_block_datetime`, `user_internal_comments`, `user_ip_address` FROM `mac_user_info` where `user_mobile` like '%1234%'";

$mainsql="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_address`,  `user_reg_datetime`, `user_reg_active`,`user_mac_blocked`, `user_mobile_blocked` FROM `mac_user_info` where 1 ";

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
if($orderby =="")
{
$orderby=" uid ";
}
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

if($j==4 ){$mysqlrow[$j]=strtoupper($mysqlrow[$j]);}
if($j==6 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="SMS not Verified";}
if($j==6 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="SMS Verified";
$ggg=0;
$mainsqlx="SELECT `userid`,`specialcodeactive` FROM `mac_code_info` WHERE `userid` = ".$mysqlrow['uid']." ";
//print "\n $mainsqlx \n";
$xmysqlresult = $mysqldblink->query($mainsqlx);
while($xmysqlrow = $xmysqlresult->fetch_array()){
$ggg=1;
if($xmysqlrow['specialcodeactive']==0){
$mysqlrow[$j]="SMS Verified Manually";
}
//print "<br>x<br>";
}

if($ggg==0){$mysqlrow[$j]="SMS Verified Manually Reg.";}
}

if($j==7 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Not Block";}
if($j==7 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="Blocked";}

if($j==8 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Not Block";}
if($j==8 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="Blocked";}
print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>
