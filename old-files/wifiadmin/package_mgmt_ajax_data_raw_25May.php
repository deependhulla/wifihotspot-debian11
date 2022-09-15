<?
include_once('dbinfo.php');
$selval=$_REQUEST['vara'];
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
$searchsql=$searchsql." `value1`  like '%".$searchbox."%'  || ";
$searchsql=$searchsql." `value2`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `value3`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `user_access_plan_name`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `no_of_devices_allowed`   like '%".$searchbox."%' || ";
$searchsql=$searchsql." `package_active`   like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";

}

$mainsql="SELECT  `uid`, `value1`,`value2`, `value3`,`user_access_plan_name`, `no_of_devices_allowed`, `package_active` FROM ( SELECT a.`uid`, a.`value1`,a.`value2`, a.`value3`,b.`user_access_plan_name`, a.`no_of_devices_allowed`, a.`package_active` FROM `wifi_package_management` as a  ,`wifi_access_plan` as b WHERE a.`access_plan_id`= b.`uid` ";


$mainsql=$mainsql." ) z WHERE 1";

if( $selval!=""){$mainsql= $mainsql." AND `package_active`= '".$selval."' ";}
#print " $mainsql ";
#exit;
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

#print "<Hr> $mainsql <hr>";
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



//if($j==4 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Unlimited";}
//if($j==5 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="No Cap";}
//if($j==6 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="No Cap";}
//if($j==7 && $mysqlrow[$j]=="0"){$mysqlrow[$j]="Free";}
print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>
