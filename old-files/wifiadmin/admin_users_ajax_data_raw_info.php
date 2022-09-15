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
$searchsql=$searchsql." `uid` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `login_name` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `login_ip` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `login_contact`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `login_active`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";

}


$mainsql="SELECT `uid`,`login_name`,`login_contact`,`login_ip`, `create_on_date`,`login_active` FROM `app_login_info` where 1";

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

if($j==5 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="InActive";}
if($j==5 && $mysqlrow[$j]=="1"){$mysqlrow[$j]="Active";}
print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>
