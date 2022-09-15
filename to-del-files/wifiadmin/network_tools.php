	<?
$submoduleid=23;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}
?>
<style>
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
</style>

<div class="container">
<h4 class="page-header">Network Tools</h4>
<?
$checkx=$_POST['checkx'];
$domain_namex = $_POST['domain_namex'];
$domain_namex=str_replace(" ","",$domain_namex);
$domain_namex=str_replace("\0","",$domain_namex);
$domain_namex=str_replace("\n","",$domain_namex);
$domain_namex=str_replace("\r","",$domain_namex);
$domain_namex=str_replace("\"","",$domain_namex);
$domain_namex=str_replace("'","",$domain_namex);
$domain_namex=str_replace(";","",$domain_namex);
$domain_namex=str_replace("|","",$domain_namex);
$domain_namex=str_replace(":","",$domain_namex);
$runcmdx="";
$titlec="";
if($domain_namex==""){$domain_namex="technoinfotech.com";}
if($checkx == 'ping'){$pingx ="selected"; $runcmdx="ping -c 4 ".$domain_namex." 2>&1";$titlec=" ping";}   
if($checkx == 'traceroute'){$trace_routex ="selected"; $runcmdx=" traceroute ".$domain_namex." 2>&1";$titlec=" traceroute";}
if($checkx == 'dig'){$dns_lookupx ="selected";$runcmdx="dig ".$domain_namex." A +noall +answer | grep -v \";\" | grep -v \"SOA\"  2>&1"; $titlec=" DNS Lookup";} 


 ?>
<form action=""  method="post" name="newadd" id="newadd" onSubmit="return showPleaseWait()" >
 <input type="hidden" name="savedetails" value="save_wifimodem" >
<div class="row">
<div class="col-md-3">Check :<select class="form-control" id="checkx" name="checkx">
<option value="ping" <?=$pingx?> selected >Ping </option>
<option value="traceroute" <?=$trace_routex?> >Trace Route</option>
<option value="dig" <?=$dns_lookupx?> >DNS Lookup </option>
</select>
</div>
<div class="col-md-3">IP / Domain Name :<input type="text"  class="form-control" id="domain_namex" name="domain_namex" value="<? echo $domain_namex;?>"required/></div>
<div class="col-md-3"> <input type="submit" id="SubmitButton"  name="SubmitButton"   class="btn btn-default" style="margin-top: 20px;" value="Check Now" ></div>
<div class="col-md-3"  id="msgDiv"></div>
</div>
<br>
<?
if($checkx!="")
{

$nodata="No Data Available  for ".$domain_namex." ".$titlec." ";
$outx="";
#print "$runcmdx";
$cmdx=`$runcmdx`;
$outx=$cmdx;
$outy=$outx;
$outy=str_replace(" ","",$outy);
$outy=str_replace("\n","",$outy);
$outy=str_replace("\t","",$outy);
$outy=str_replace("\r","",$outy);
$outy=str_replace("\0","",$outy);
if($outy==""){$outx="";}
if($outx==""){$outx=$nodata;}
print '<pre style="text-align: left;">'.$outx.'<br>&nbsp;</pre>';

}
?>
<br>
</form>

<?
$type_start=$_REQUEST['type_start'];
$type_stop=$_REQUEST['type_stop'];
$type_yes=$_REQUEST['type_yes'];
$type_no=$_REQUEST['type_no'];
$start=$_REQUEST['start'];
$stop=$_REQUEST['stop'];
#if(isset($_POST['stop'])){
if($type_stop=='stop'){
$sqlxzz="UPDATE `internet_tools` SET `current_status` = '0'";
$mysqlresultss = $mysqldblink->query($sqlxzz);
}
#}
#if(isset($_POST['start'])){
if($type_start=='start'){
$sqlxz="UPDATE `internet_tools` SET `current_status` = '1'";
$mysqlresults = $mysqldblink->query($sqlxz);
}
#}
$autos = $_POST['autos'];
#if(isset($_POST['go']))
#{
if($type_yes=='yes'){
$sqlxz="UPDATE `internet_tools` SET `automatic_internet` = '1',`start_time`=NOW()";
$mysqlresults = $mysqldblink->query($sqlxz);
}
if($type_no=='no'){
$sqlxz="UPDATE `internet_tools` SET `automatic_internet` = '0',`end_time`=NOW()";
$mysqlresults = $mysqldblink->query($sqlxz);
}
#}

$sqlxz11="SELECT uid,current_status,automatic_internet,start_time,end_time FROM `internet_tools`";
$mysqlresult11 = $mysqldblink->query($sqlxz11);
while($mysqlrow11 = $mysqlresult11->fetch_array()){
#print_r($mysqlrow11);
$getuid=$mysqlrow11['uid'];
$status=$mysqlrow11['current_status'];
$autoInternet=$mysqlrow11['automatic_internet'];
$start_time=$mysqlrow11['start_time'];
$end_time=$mysqlrow11['end_time'];
if($autoInternet==1){
$internetActive='checked';
}else{
$internetInActive= 'checked';
}
}
?>
<!--Script for Confirmation After click on button-->
<script>
function confirmstart(){
var y=confirm("Are you sure you want to Shut down Internet");
if(y==true){
window.location="network_tools.php?uid=<?=$getuid;?>&type_start=start";
}}
</script>

<script>
function confirmstop(){
var y=confirm("Are you sure you want to Start Internet");
if(y==true){
window.location="network_tools.php?uid=<?=$getuid;?>&type_stop=stop";
}}
</script>
<script> 
function confirmyes(){
var y=confirm("Are you sure you want to Start Internet Automatic");
if(y==true){
window.location="network_tools.php?uid=<?=$getuid;?>&type_yes=yes";
}} 
</script>
<script> 
function confirmno(){
var y=confirm("Are you sure you want to Stop Internet Automatic");
if(y==true){
window.location="network_tools.php?uid=<?=$getuid;?>&type_no=no";
}}
</script>

<div class="row">
<div class="col-md-6">
<fieldset class="scheduler-border">
<legend class="scheduler-border">Wifi Internet Status</legend>
<form action="" method="POST">
<?php if($status==0){
echo "Current Status: ";
?>
<input type="submit" name="start" value="Running" class="btn btn-sm btn-success" onClick="confirmstart(); return false;">
<?php } if($status==1) {
echo "Current Status: ";
?>
<input type="submit" name="stop" value="Stopped" class="btn btn-sm btn-danger" onClick="confirmstop(); return false;">
<?php } ?>
<br/>
<br/>
<span class="glyphicon glyphicon-play text-success"></span>
Click here to Automatic Start And Stop:
<label><input type="radio" name="autos" value="1" <?php echo $internetActive; ?> onClick="confirmyes(); return false;">Yes</label>
<label><input type="radio" name="autos" value="0" <?php echo $internetInActive; ?> onClick="confirmno(); return false;">No</label>
<input type="submit" name="go" value="Go"> 
<br/><b>Start Time:</b> <?php echo date('h:i A',strtotime($start_time));?>
<br/><b>End Time:</b> <?php echo date('h:i A',strtotime($end_time));?>
</form>

</fieldset>
</div>
</div>
</div>
</body>
</html>

<?
//}
html_footer_to_show();
?>
