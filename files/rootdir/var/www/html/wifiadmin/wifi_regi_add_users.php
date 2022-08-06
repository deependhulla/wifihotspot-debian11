<?
$submoduleid=1;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<div class="container">
<h4 class="page-header">Add Wifi Users</h4>
<?
$savedetails_wifi=$_POST['savedetails_wifi'];
if($savedetails_wifi=='savewifi')
//if(isset($_POST['save_wifi']))
{
//print_r($_POST);
$savedetails_wifi=$_POST['savedetails_wifi'];
$user_full_name=$_POST['user_full_name'];
$user_mac_address=$_POST['user_mac_address'];
$user_mobile=$_POST['user_mobile'];

$user_email=$_POST['user_email'];
$useremailbreak=array();
$useremailbreak=explode("@",$user_email);
//print "DOMain :".$useremailbreak[1];
$getdomainipx=gethostbyname($useremailbreak[1]);
//print "-->".$getdomainipx."<--";
$domainok=1;

$sqlxy = "SELECT user_mac_address FROM mac_user_info  WHERE user_mac_address = '$user_mac_address'";
//print $sqlxy;
$mysqlresult1 = $mysqldblink->query($sqlxy);
$countx=mysqli_num_rows($mysqlresult1);

if(empty($user_full_name))
{
echo "<div class='alert alert-danger'>Please enter Name</div>";
}
elseif(empty($user_mobile))
{
echo "<div class='alert alert-danger'>Please enter 10 digit Mob No</div>";
}
elseif(empty($user_email))
{
echo "<div class='alert alert-danger'>Please enter Email</div>";
}
elseif($getdomainipx == $useremailbreak[1])
{
$domainok=0;
echo "<div class='alert alert-danger'>Please enter valid Email</div>";
}
elseif(empty($user_mac_address))
{
echo "<div class='alert alert-danger'>Please enter Mac Address</div>";
}
elseif(!preg_match('/^([0-9a-fA-F][0-9a-fA-F]:){5}([0-9a-fA-F][0-9a-fA-F])$/',$user_mac_address))
{
echo "<div class='alert alert-danger'>Please Enter Valid MAC ID</div>";
}
elseif($countx >= 1){
echo "<div class='alert alert-danger'>Mac ID already exist</div>";
}
else{


$sqlxz="SELECT uid,user_access_plan_name FROM wifi_access_plan";
$mysqlresultxz = $mysqldblink->query($sqlxz);
$uid=$_POST['uid'];
//$user_mac_address=strtoupper($_POST['user_mac_address']);
$user_full_name=$_POST['user_full_name'];
$user_access_plan_name=$_POST['user_access_plan'];
$user_mobile=$_POST['user_mobile'];
$user_reg_active=$_POST['user_reg_active'];
$user_email=$_POST['user_email'];
$savedetails_wifi=$_POST['savedetails_wifi'];

$donexx=0;
//if($savedetails_wifi=='savewifi'){
$sqlx="INSERT INTO `mac_user_info`( `user_full_name`, `user_mobile`, `user_email`, `user_mac_address`,`user_reg_active`,`user_access_plan`) VALUES ( '$user_full_name', '$user_mobile', '$user_email','$user_mac_address', '$user_reg_active','$user_access_plan_name');";
 $mysqlresult = $mysqldblink->query($sqlx);
if($mysqlresult){
$donexx=1;
?>
<div class="alert alert-success">
<a href="#" "close" data-dismiss="alert">&times;</a>
<strong>Success!</strong> Your WIFI User Created Successfully.
</div>
<?} 
}
} 

if($donexx==0)
{
?>

<form action=""  method="post" name="newadd" id="newadd"  >
<input type="hidden" name="savedetails_wifi" value="savewifi">

<div class="row">
<div class="col-md-4">
Name : <input type="text" class="form-control" name="user_full_name" value="<?=$user_full_name?>"  >
</div>
<div class="col-md-4">
Mobile No: <input type="text" class="form-control" name="user_mobile" value="<?=$user_mobile?>" pattern="[0-9]{10}" title="10 digits Mobile No"/>
</div>
<div class="col-md-4">
Email : <input type="email" class="form-control" id="user_email"name="user_email" value="<?=$user_email?>" />
</div>
</div>
<div class="row">
<div class="col-md-4">
Mac Address(example- 98:D6:F7:67:8C:B6) :<input type="text" class="form-control" name="user_mac_address" value="<?=$user_mac_address?>" />
</div>

<div class="col-md-4">
Verification Status :<select class="form-control" name="user_reg_active">
<option value="1" <?=$active ?> >SMS Verified </option>
<option value="0" <?=$inactive ?> >SMS not Verified </option>
</select>
</div>
<!--<div class="col-md-4">
Access Plan :<select  class="form-control" name="user_access_plan">
<?foreach ($mysqlresultxz as $row){
echo "<option value=$row[uid]>$row[user_access_plan_name]</option>";
}

?>
</select>
</div>-->
</div>
<br/>
<button class="btn btn-default" name="save_wifi" value="Save Details" onclick="save_wifi_user(); return false;">Create Wifi  User</button></form>
<?}?>
</div>


<?
}
html_footer_to_show();
?>
