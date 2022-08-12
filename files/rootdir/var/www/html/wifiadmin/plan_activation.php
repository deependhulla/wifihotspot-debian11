<?php
$allokv=1;
$submoduleid=18;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
$search_deviceid=$_REQUEST['search_deviceid'];
$up_new_plan=$_POST['up_new_plan'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<div class="container">
<h4 class="page-header"><?php echo $moduletitle;?></h4>
<form action="" method="POST" name="search_device" id="search_device">
<input type="hidden" name="search_deviceid" value="searchdevice">
<div class="row">
<div class="col-md-2" style="vertical-align: bottom;">
Enter Unique Device ID : 
</div>
<div class="col-md-2">
<input type="text" class="form-control" name="uid" size=10 style="widthu:200px" required/></div>
<button class="btn btn-primary" name="search_device_id" value="Search Details" onclick="go_deviceid(); return false;">Go</button>
</form>
<br>
<br>

<?php

if (isset($_POST['up_new_plan']) && $_POST['up_new_plan']=='newplan') {
if(isset($_POST['upline_new_plan']))
{
$v_type = $_POST['verify_type'];
 $verify_info=$_POST['verify_info'];
 $uidy=$_POST['updatenewpl'];
$planid=$_POST['user_access_plan'];


$allokv=1;
$gotmin=0;
//$donexx=1;
$notallowed=0;
$sqlz="SELECT `uid`, `create_by_user`, `create_on_date`, `create_type`, `reset_daily`, `user_access_plan_name`, `user_ip_notallowed_list`, `validity_period_in_mins`, `traffic_limit_in_mb`, `basic_upload_max_speed_kbps`, `basic_download_max_speed_kbps`, `special_ip_list`, `access_plan_active`, `internal_notes`, `plan_price`, `traffic_reset_limit_in_mb`, `traffic_reset_period` FROM `wifi_access_plan` WHERE `uid` =  ".$planid."";
#print "<hr>$sqlz<hr>";
$zmysqlresult = $mysqldblink->query($sqlz);
while($zmysqlrow = $zmysqlresult->fetch_assoc()){
$gotmin=$zmysqlrow['validity_period_in_mins'];
$traffic_limit_in_mb_insert=$zmysqlrow['traffic_limit_in_mb'];
$plan_price_insert=$zmysqlrow['plan_price'];
$traffic_reset_limit_in_mb_insert=$zmysqlrow['traffic_reset_limit_in_mb'];
$traffic_reset_period_insert=$zmysqlrow['traffic_reset_period'];
$basic_upload_max_speed_kbps=$zmysqlrow['basic_upload_max_speed_kbps'];
$basic_download_max_speed_kbps=$zmysqlrow['basic_download_max_speed_kbps'];
}



if($v_type == "PAN_CARD"){

if(empty($verify_info))
{
 $allokv=0;
 $error_fname="Please enter PAN Card number.";
}
elseif (preg_match('/^([A-Z]){5}([0-9]){4}([A-Z]){1}?$/', $verify_info))
{
$verify_info_new = $verify_info;
}
else
{
$allokv=0;
$error_fname='PAN structure is as follows: AAAPL1234C: First five characters are letters, next four numerals, last character letter.';
}
}

if($v_type == "AADHAAR_CARD"){
if(is_numeric($verify_info) == false )
{
$allokv=0;
$error_fname= "Please enter numeric Aadhar card ID.";
}
elseif (strlen($verify_info)>12 || strlen($verify_info)<12)
{
$allokv=0;
$error_fname= "Number should be 12 digits.";
}
else
{
$verify_info_new= $verify_info;
}
}


$additional_notes=$_POST['additional_notes'];
//$verify_info=$_POST['verify_info'];
$additional_notes=mysqli_real_escape_string($mysqldblink,$additional_notes);
$verify_info=mysqli_real_escape_string($mysqldblink,$verify_info);
if($allokv==0){
$search_deviceid='searchdevice';
$getuid=$uidy;
}
if($allokv==1){
$ipAddress="";
$sqlx="INSERT INTO `wifi_live_plans` (`uid` ,`logid` ,`create_by_user` ,`create_on_date` ,`create_type` ,`mac_uid` ,`plan_uid` ,`start_time` ,`end_time` ,`access_plan_live` ,`verify_type` ,`verify_info` ,`additional_notes`, `traffic_reset_limit_in_mb`, `traffic_reset_period`, `traffic_limit_in_mb`, `plan_price`, `basic_upload_max_speed_kbps`,`basic_download_max_speed_kbps`)VALUES (NULL , NULL , '".$userloginname."', NOW( ) , '', '".$uidy."', '".$planid."', NOW(), DATE_ADD(NOW(), INTERVAL '".$gotmin."' MINUTE), '1', '".$v_type."', '".$verify_info."', '".$additional_notes."','".$traffic_reset_limit_in_mb_insert."','".$traffic_reset_period_insert."','".$traffic_limit_in_mb_insert."','".$plan_price_insert."','$basic_upload_max_speed_kbps','$basic_download_max_speed_kbps');";

#print "$sqlx ";
$mysql="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan`,`user_mac_address`,`user_reg_datetime`,user_ip_address FROM `mac_user_info` where `uid` = ".$uidy;
$umysqlresult = $mysqldblink->query($mysql);
if($urow = $umysqlresult->fetch_array()){
$macAddr=$urow['user_mac_address'];
$ipAddress=$urow['user_ip_address'];

}

if($ipAddress ==""){
$cmdz='arp -a | grep -i "00:17:31:9B:0E:16" | cut -d "(" -f 2 | cut -d ")" -f 1';
$ipgotzz=`$cmdz`;
$ipgotzz=str_replace("\n","",$ipgotzz);
$ipgotzz=str_replace("\r","",$ipgotzz);
$ipgotzz=str_replace("\t","",$ipgotzz);
$ipgotzz=str_replace(" ","",$ipgotzz);
##print "-->".$ipgotzz."<--";
$ipAddress=$ipgotzz;
}

$cmdx="/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' \"https://127.0.0.1:8383/wifidirect/index.cgi?macx=".$macAddr."&macipx=".$ipAddress."&activenow=1&dmax=".$basic_download_max_speed_kbps."&umax=".$basic_upload_max_speed_kbps."&uid=".$uidy."\"";
$cmdxs=`$cmdx`;
#print "<hr> $cmdx<hr>";



#print "\n  <hr> $sqlx <hr>\n";

$mysqlresultb=$mysqldblink->query($sqlx);
if($mysqlresultb){

?>
	<div class="alert alert-success">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Access Plan Applied  Successfully.
        </div>

<?php
}
}
}
}
if($search_deviceid=='searchdevice'){
$donexx=1;
$notallowed=0;
$mysql="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan`,`user_mac_address`,`user_reg_datetime` FROM `mac_user_info` where `uid` = ".$getuid;
$mysqlresult = $mysqldblink->query($mysql);
if($mysqlrow = $mysqlresult->fetch_array()){
$getuid=$mysqlrow['uid'];
$user_full_name=$mysqlrow['user_full_name'];
$user_mobile=$mysqlrow['user_mobile'];
$user_email=$mysqlrow['user_email'];
$user_access_plan=$mysqlrow['user_access_plan'];
$user_mac_blocked=$mysqlrow['user_mac_blocked'];
$user_mobile_blocked=$mysqlrow['user_mobile_blocked'];
$user_reg_active=$mysqlrow['user_reg_active'];
$user_mac_address=$mysqlrow['user_mac_address'];
$user_reg_datetime=$mysqlrow['user_reg_datetime'];
if($user_reg_active==1){
$user_reg_active="<span style='color: green'>SMS Verified</span>";
}else{
$user_reg_active= "<span style='color: red'>SMS Not Verified</span>";
$notallowed=1;
}
if($user_mobile_blocked==1){
$user_mobile_blocked="<span style='color: red'>Blocked</span>";
$notallowed=1;
}else{
$user_mobile_blocked= "<span style='color: green'> Not Blocked </span>";
}
if($user_mac_blocked==1){
$user_mac_blocked="<span style='color: red'>Blocked</span>";
$notallowed=1;
}else{
$user_mac_blocked= "<span style='color: green'>Not Blocked</span>";
}
}else{
?>
<div class="alert alert-danger">
        <a href="#" "closex" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Your Device ID does not exist.
    </div>
<?php
}
$sqlu="SELECT user_access_plan_name FROM wifi_access_plan where `uid`=$user_access_plan";
$mysqlresultu = $mysqldblink->query($sqlu);
if($mysqlrow = $mysqlresultu->fetch_array()){
//echo $sqlu;
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
}
}
?>

<?php
if($donexx==1)
{
?>
 <div class="box">
   <div class="box-header">
   <h3 class="box-title">Information of Device ID : <?php echo $getuid;?></h3>
<button class="btn btn-primary" onclick="myFunction()">Print Invoice for POS</button>
<button class="btn btn-primary" onclick="myFunction1()">Print Invoice for A4</button>
<button class="btn btn-primary" onclick="window.open('device_plan_history.php?uid=<?php echo $getuid;?>');">See Plan History</button>
<br><br>
<script>
function myFunction() {
    window.open("print_invoice_pos.php?uid=<?php echo $getuid;?>", "_blank", "menubar=0,location=0, resizable=yes, top=100, left=200, width=900, height=700");
}
</script>
<script>
function myFunction1() {
    window.open("print_invoice_a4.php?rtype=pactivenormal&uid=<?php echo $getuid;?>", "_blank", "menubar=0,location=0, resizable=yes, top=200, left=400");
}
</script>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
<tr><td>Name : <?php echo $user_full_name;?>
</td><td>Mobile No : <?php echo $user_mobile;?>
</td></tr>
<tr><td>Email : <?php echo $user_email;?>
</td><td>Verification Status : <?php echo $user_reg_active;?>
</td></tr>
<tr><td>Mobile Status : <?php echo $user_mobile_blocked;?>
</td><td>MAC Status : <?php echo $user_mac_blocked;?>
</td></tr>
<tr><!--<td>
Default Plan : <?php echo $user_access_plan_name;?>
</td>-->
<td>
Registration Date : <?php echo $user_reg_datetime;?>
</td>
<td>
MAC : <a href="index.php?rtype=macview&macid=<?php echo $user_mac_address;?>"><?php echo $user_mac_address;?></a>
</td></tr>
<?php 
$expireday="";
$startday="";
$planbyuser="Default";
$lastplan=$user_access_plan_name;
$sqlx="SELECT  a.`verify_type`,a.`verify_info`,a.`additional_notes`,a.`create_by_user` , a.`create_on_date` , a.`mac_uid` , a.`plan_uid` , a.`start_time` , a.`end_time` , a.`access_plan_live`, b.`user_access_plan_name`, a.`traffic_limit_in_mb`, a.`traffic_reset_limit_in_mb`,b.`basic_upload_max_speed_kbps`,b.`basic_download_max_speed_kbps`, a.`traffic_reset_period`, a.`plan_price`,a.`package_uid` FROM `wifi_live_plans` a, `wifi_access_plan` b WHERE a.`plan_uid` =b.`uid` and a.`mac_uid`=".$getuid." ORDER BY a.uid DESC limit 0,1";
#print "$sqlx";
$mysqlresult = $mysqldblink->query($sqlx);
if($mysqlrow = $mysqlresult->fetch_array()){

$lastplan=$mysqlrow['user_access_plan_name'];
$startday=$mysqlrow['start_time'];
$expireday=$mysqlrow['end_time'];
$createdt=$mysqlrow['create_on_date'];
$traffic_limit_in_mb=$mysqlrow['traffic_limit_in_mb'];
$traffic_reset_limit_in_mb=$mysqlrow['traffic_reset_limit_in_mb'];
$traffic_reset_period=$mysqlrow['traffic_reset_period'];
$basic_upload_max_speed_kbps=$mysqlrow['basic_upload_max_speed_kbps'];
$basic_download_max_speed_kbps=$mysqlrow['basic_download_max_speed_kbps'];
$plan_price=$mysqlrow['plan_price'];
$package_uid=$mysqlrow['package_uid'];
$verify_typet=$mysqlrow['verify_type'];
$verify_infot=$mysqlrow['verify_info'];
if($mysqlrow['create_by_user']!="")
{
$planbyuser=$mysqlrow['create_by_user'];
}
}

$todaydate = date("Y-m-d H:i:s");
if($todaydate > $expireday){
$expireday="<span style='color: red;'>$expireday</span>";
}else {
$expireday="<span style='color: green;'>$expireday</span>";

}

if($traffic_reset_limit_in_mb == "0"){
$traffic_reset_limit_in_mb_text="No Cap";
}
?>
<tr>
<td colspan="2">
<center><b>Current / Last Plan</b></center>
<table class="table table-bordered">
<tr>
<th>Plan Name :</th><td> <?php echo $lastplan;?></td>
</tr>
<tr>
<th>Started :</th><td> <?php echo $startday;?></td>
</tr>
<tr>
<th>Expires :</th><td> <?php echo $expireday;?></td>
</tr>
<tr>
<th>Traffic Limit For Valid Period :</th><td> <?php if($traffic_limit_in_mb == "0"){ echo "Unlimited"; } else {?> <?php echo $traffic_limit_in_mb. " MB" ; }?></td>
</tr>
<tr>
<th>Traffic Reset Limit :</th><td> <?php if($traffic_reset_limit_in_mb == "0"){ echo "No Cap"; } else {?> <?php echo $traffic_reset_limit_in_mb. " MB"; }?></td>
</tr>
<tr>
<th>Traffic Reset Limit For Valid Period :</th><td> <?php if($traffic_reset_period == "0"){ echo "No Cap"; } else {?> <?php echo $traffic_reset_period. " Days"; }?></td>
</tr>
<!-- <tr>
<th>Upload Speed in kbps :</th><td> <?php if($basic_upload_max_speed_kbps == "0"){ echo "Unlimited"; } else {?> <?php echo $basic_upload_max_speed_kbps. " kbps"; }?></td> 
</tr> -->

<tr>
<th>Download Speed in kbps :</th><td> <?php if($basic_download_max_speed_kbps == "0"){ echo "Unlimited"; } else {?> <?php echo $basic_download_max_speed_kbps. " kbps"; }?></td>
</tr>

<tr>
<th>Verification Type :</th><td><?php echo $verify_typet;?></td>
</tr>
<tr>
<th>Verification ID :</th><td><?php echo $verify_infot;?></td>
</tr>
<tr>
<th>Plan Applied by :</th><td><?php echo $planbyuser;?>  on <?php echo $createdt;?></td>
</tr>
<tr>
<th>Plan Price(INR) :</th><td> <?php if($plan_price == "0"){ echo "Free"; } else {?> <?php echo $plan_price; }?></td>
</tr>
<tr>
<th>Package UID :</th><td> <?php if($package_uid == "0"){ echo "None"; } else {?> <?php echo $package_uid; }?></td>
</tr>
</table>
</td>
</tr>
</table>
</div></div><?php
if($notallowed==1){
?>
<div class="alert alert-danger">
        <a href="#" "closex" data-dismiss="alert">&times;</a>
        <strong>Plan Activation Disabled!</strong> This Device is not verified or Blocked.
    </div>

<?php
}




if($notallowed==0){

if($allokv==0){
?>
<div class="alert alert-danger">
        <a href="#" "closex" data-dismiss="alert">&times;</a>
        <strong>Error - <?php echo $error_fname;?></strong>
    </div>

<?php
}

?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="upline_newplan" id="upline_newplan">
<input type="hidden" name="up_new_plan" value="newplan" >
<input type="hidden" name="updatenewpl" value="<?php echo $getuid;?>" >
<div class="row">
<div class="col-md-8">
Assign new access plan :
<select   id="user_access_plan" class="form-control" name="user_access_plan" required>
<option value="" selected>Select Access Plan</option>
<?php

$sqlxz="SELECT uid,user_access_plan_name FROM wifi_access_plan where `access_plan_active`=1";
$mysqlresultxz = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresultxz->fetch_array()){
$uidxx=$mysqlrow['uid'];
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
//echo "<option value='$uidxx'>shr</option>";
echo "<option value='$uidxx'>$user_access_plan_name</option>";
}
?>
</select>
</div>
</div>
<div class="row">
<div class="col-md-4">
Manual Verification via :
<select   id="verify_type" class="form-control" id="verify_type" name="verify_type" required>
<option value="" selected>Select</option>
<?php

$sqlxz="SELECT `verify_type_name` FROM `verify_type_details` ORDER BY `uid` DESC ";
$mysqlresultxz = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresultxz->fetch_array()){
$verify_type_name=$mysqlrow['verify_type_name'];
echo "<option value='".$verify_type_name."'>".$verify_type_name."</option>";
}
?>
</select>
</div>

<div class="col-md-4">
Verification ID Information : <input type="text" class="form-control" name="verify_info" value="<?php echo $verify_info_new; ?>"/>
</div>
</div>

<div class="row">
<div class="col-md-8">
Short description about user : <input type="text" class="form-control" name="additional_notes"  /></div>
</div>

<div class="col-md-4">
<br>
<input type="submit" class="btn btn-primary"  name="upline_new_plan" value="Apply New Plan"> 
<!--<button   class="btn btn-primary" name="upline_new_plan" value="Save Details">Apply New Plan</button>-->
<br>&nbsp;</div>
</form>
<?php
}
?>
</div>
<?php
}
?>

</div>

<?php
}
html_footer_to_show();
?>
