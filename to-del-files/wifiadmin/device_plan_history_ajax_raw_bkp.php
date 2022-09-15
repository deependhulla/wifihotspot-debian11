<?
include_once('dbinfo.php');
foreach($_REQUEST as $key=>$value)$$key=$value;
$limit=$length;
$srno=0;
$rtype=$_REQUEST['rtype'];
$getuid=$_REQUEST['uid'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];

if($start==""){$start=0;}
if($limit==""){$limit=15;}


$srno=$start+1;

$searchbox=$search['value'];
$orderby="";
$searchsql="";



if($rtype=="deviceplanhistory")
{
if($searchbox!="" )
{
$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `start_time` like '%".$searchbox."%'   || ";
$searchsql=$searchsql." `user_access_plan_name` like '%".$searchbox."%'  || ";
//$searchsql=$searchsql." `plan_price` like '%".$searchbox."%' || ";
$searchsql=$searchsql." )  ";
}



$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$enddatex=$enddate;
$enddatex=str_replace("-","_",$enddatex);

$mainsql="SELECT  `start_time`, `end_time`, `create_by_user`, `user_access_plan_name`, `verify_type`, `verify_info`, `plan_price` FROM ( SELECT  a.`start_time`,a.`end_time`,a.`create_by_user`,c.`user_access_plan_name`,a.`verify_type`,a.`verify_info`,a.`plan_price` FROM `wifi_live_plans` as a  ,`mac_user_info` as b,`wifi_access_plan` as c WHERE a.`mac_uid` = b.`uid` AND  a.`plan_uid`= c.`uid` AND b.`uid` = '".$getuid."' AND DATE(a.`create_on_date`) >= '".$startdate."' AND DATE(a.`create_on_date`) <= '".$enddate."' ) z WHERE 1 ";
}


$mysqlresult = $mysqldblink->query($mainsql);
$rtotal=0;
while($mysqlrow = $mysqlresult->fetch_array()){$rtotal++;
if($rtotal==1)
{
for($e=0;$e>sizeof($order);$e++)
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
if($orderby =="" )
{
$orderby=" create_on_date DESC";
}


if($orderby!="")
{
$mainsql=$mainsql." ORDER BY ".$orderby;
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
