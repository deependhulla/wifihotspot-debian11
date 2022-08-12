<?php
$submoduleid=1;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}

$savefun=$_POST['savefun'];
$action_wifiu=$_REQUEST['action_wifiu'];

if($userlogin==1 && $accessokformodule==1)
{
if($_GET['uid']!="")
{
$gotuidx= $_GET['uid'];
}
?>
<div class="container">
<h4 class="page-header">Wifi Registered Users |  &nbsp; UID:<?php echo $gotuidx;?></h4>

<?php

if(isset($_POST['savefun']))
{
$user_email=$_POST['user_email'];

$useremailbreak=array();
$useremailbreak=explode("@",$user_email);
//print "DOMain :".$useremailbreak[1];
$getdomainipx=gethostbyname($useremailbreak[1]);
//print "-->".$getdomainipx."<--";
$domainok=1;
if($getdomainipx == $useremailbreak[1])
{
$domainok=0;
?>
<div class="alert alert-danger"> Please enter valid Email.</div>
<?php
}else{

if($savefun=="savedetails")
{
if($_POST['user_access_plan']==""){$_POST['user_access_plan']=0;}
$sqlb="UPDATE `mac_user_info` SET ";
$sqlb=$sqlb."`create_by_user`= '". $userloginname ."', " ;
$sqlb=$sqlb."`user_full_name`= '". csx($_POST['user_full_name']) ."', " ;
$sqlb=$sqlb."`user_mobile`= '". csx($_POST['user_mobile']) ."', " ;
$sqlb=$sqlb."`user_reg_active`= '". csx($_POST['user_reg_active']) ."', " ;
$sqlb=$sqlb."`user_email`= '". csx($_POST['user_email']) ."', " ;
$sqlb=$sqlb."`user_access_plan`= '". csx($_POST['user_access_plan']) ."', " ;
$sqlb=$sqlb."`user_mac_blocked`= '". csx($_POST['user_mac_blocked']) ."', " ;
$sqlb=$sqlb."`user_mobile_blocked`= '". csx($_POST['user_mobile_blocked']) ."' " ;
$sqlb=$sqlb." where `uid` =' ".$gotuidx."' " ;
#print $sqlb;
$mysqldblink->query($sqlb);

header("Location: wifi_regi.php");


}}}

//$mainsql="SELECT a.`uid`, b.`user_access_plan_name` FROM `mac_user_info`as a ,`wifi_access_plan` as b    where 1 and a.`user_access_plan`=b.`uid` ";
//$mysqlr = $mysqldblink->query($mainsql);

$mysql="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan` FROM `mac_user_info` where `uid` = ".$gotuidx;
$mysqlresult = $mysqldblink->query($mysql);

while($mysqlrow = $mysqlresult->fetch_array()){
//print_r($mysqlrow);
$gotuidx=$mysqlrow['uid'];
$user_full_name=$mysqlrow['user_full_name'];
$user_mobile=$mysqlrow['user_mobile'];
$user_email=$mysqlrow['user_email'];
$user_access_plan=$mysqlrow['user_access_plan'];
$user_mac_blocked=$mysqlrow['user_mac_blocked'];
$user_mobile_blocked=$mysqlrow['user_mobile_blocked'];
$user_reg_active=$mysqlrow['user_reg_active'];

if($mysqlrow['user_reg_active']=="1"){$active="selected";}
if($mysqlrow['user_reg_active']=="0"){$inactive="selected";}

if($mysqlrow['user_mobile_blocked']=="1"){$blocked="selected";}
if($mysqlrow['user_mobile_blocked']=="0"){$noblocked="selected";}

if($mysqlrow['user_mac_blocked']=="1"){$blockedx="selected";}
if($mysqlrow['user_mac_blocked']=="0"){$noblockedx="selected";}
}
$sqlxz="SELECT uid,user_access_plan_name FROM wifi_access_plan";
$mysqlresultxz = $mysqldblink->query($sqlxz);

?>

<?php
if( $action_wifiu=='delete' )
{
$macAddr="";
### work for Deactive first. --start
$mysql="SELECT `uid`, `user_mac_address`,`user_ip_address`,`user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan` FROM `mac_user_info` where `uid` = ".$gotuidx;
$mysqlresult = $mysqldblink->query($mysql);

while($mysqlrow = $mysqlresult->fetch_array()){
//print_r($mysqlrow);
$macAddr=$mysqlrow['user_mac_address'];
$ipAddress=$mysqlrow['user_ip_address'];
}
$cmdx="/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' \"https://127.0.0.1:8383/wifidirect/index.cgi?macx=".$macAddr."&macipx=".$ipAddress."&activenow=0&gotuidx=".$gotuidx."\"";
$cmdxs=`$cmdx`;
#print "<hr> $cmdx<hr>";
#exit;
### work for Deactive first. --end

$sqldelete = "DELETE FROM mac_user_info WHERE uid ='$gotuidx'";
$mysqldelete=$mysqldblink->query($sqldelete);
header("Location: wifi_regi.php");
}
?>

<form action=""  method="post" name="myform" id="myform" onSubmit="return confirmForm(this);">
<input type="hidden" name="savefun" value="savedetails">

<div class="row">
<div class="col-md-4">
Name : <input type="text" class="form-control" name="user_full_name" value="<?php echo $user_full_name; ?>" >
</div>
<div class="col-md-4">
Mobile No: <input type="tel" class="form-control" name="user_mobile" value="<?php echo $user_mobile; ?>" pattern="[0-9]{10}" title="10 digits Mobile No" required/>
</div>
<div class="col-md-4">
Email : <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>" >
</div>
</div>
<div class="row">


<div class="col-md-4">
Verification Status :<select class="form-control" name="user_reg_active">
<option value="1" <?php echo $active; ?> >SMS Verified</option>
<option value="0" <?php echo $inactive; ?> >SMS Not Verified</option>
</select>
</div>

<div class="col-md-4">
Mob Block :<select class="form-control" name="user_mobile_blocked">
<option value="1" <?php echo $blocked; ?> >Blocked </option>
<option value="0" <?php echo $noblocked; ?> >Not Block </option>
</select>
</div>
<div class="col-md-4">
Mac Block :<select class="form-control" name="user_mac_blocked">
<option value="1" <?php echo $blockedx; ?> >Blocked </option>
<option value="0" <?php echo $noblockedx; ?> >Not Block </option>
</select>
</div>
</div>
<!--<div class="row">
<div class="col-md-4">
Access Plan :
<select   id="user_access_plan" class="form-control" name="user_access_plan" value="<?php echo $user_access_plan;?>">
<?php
while($mysqlrow = $mysqlresultxz->fetch_array()){
$uid=$mysqlrow['uid'];
$user_access_plan_name=$mysqlrow['user_access_plan_name'];

echo "<option value='$uid'>$user_access_plan_name</option>";

}
?>
</select>
</div>
</div>-->
<br/>
<button  name="saveusers" value="Save User" class="btn btn-default" onclick="save_wifi_user();return false;"><span>Save</span></button>

<a href="wifi_edit_users.php?uid=<?php echo $gotuidx;?>&action_wifiu=delete" id="del_wifiuser" class="btn btn-default" onclick="return confirm('Do you really want to delete this?')">Delete</a>
</form>

</div>
<script>
 document.getElementById('user_access_plan').value ="<?php echo $user_access_plan;?>";
</script>

<?php
}
html_footer_to_show();
?>
 
