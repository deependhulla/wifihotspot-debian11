<?
include_once('dbinfo.php');
foreach($_REQUEST as $key=>$value)$$key=$value;
$limit=$length;
$srno=0;
if($start==""){$start=0;}
if($limit==""){$limit=55;}

$srno=$start+1;

$searchbox=$search['value'];
$orderby="";
$searchsql="";

if($searchbox!="")
{

$searchsql=$searchsql." AND (  ";
$searchsql=$searchsql." `uid` like '%".$searchbox."%' || ";
$searchsql=$searchsql." `msg_in_config` like '%".$searchbox."%' || ";
$searchsql=$searchsql." `msg_data` like '%".$searchbox."%' ";
$searchsql=$searchsql." )  ";

}


$mainsql="SELECT `uid`,`msg_in_config`, `msg_data` FROM `config_info` WHERE 1 and `uid` !=15 and `uid`!=16 ";

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
while($mysqlrow = $mysqlresult->fetch_array()){$rstotal++; 
$id = $mysqlrow['uid'];
}
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

if($j==2 && $mysqlrow[$j]=="0"  && $mysqlrow['uid']=="11"){$mysqlrow[$j]="Basic SMS Verification";}
if($j==2 && $mysqlrow[$j]=="1" && $mysqlrow['uid']=="11"){$mysqlrow[$j]="Package SMS Verification";}
if($j==2 && $mysqlrow[$j]=="2"  && $mysqlrow['uid']=="11"){$mysqlrow[$j]="Package Direct Verification";}
if($j==2 && $mysqlrow[$j]=="0"  && $mysqlrow['uid']=="20"){$mysqlrow[$j]="Hidden";}
if($j==2 && $mysqlrow[$j]=="1" && $mysqlrow['uid']=="20"){$mysqlrow[$j]="Plain Text Check";}
if($j==2 && $mysqlrow[$j]=="2"  && $mysqlrow['uid']=="20"){$mysqlrow[$j]="Check Mob No";}
if($j==2 && $mysqlrow[$j]=="1" && $mysqlrow['uid']=="18"){$mysqlrow[$j]="ON";}
if($j==2 && $mysqlrow[$j]=="0" && $mysqlrow['uid']=="18"){$mysqlrow[$j]="OFF";}

if($j==2){
$mysqlrow[$j]=htmlentities($mysqlrow[$j]);

$position = 40;
$mysqlrow[$j] = substr($mysqlrow[$j], 0, $position);
}

if($j==2 && $mysqlrow['uid']=="19")
{ $mysqlrow[$j]='<a href=\"../wifilogin/terms.php\" target=\'_blank\' >Click Here to View</a>'; }

print "\"".$mysqlrow[$j]."\"";
}
#print '["1","Sikander Ali","9648741205","sikander@yahoo.com","00:17:31:9b:0e:17","2014-11-07, 5:22 pm","1","0","0","172.16.201.3"]';
print "]";

print "";

}
print ']}';

?>

