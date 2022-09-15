<?
$submoduleid=21;
include_once('common_tools.php');
$ipAdd=$_SERVER['REMOTE_ADDR'];
if($userlogin==1){html_header_to_show();}
?>
<div class="container">
<h4 class="page-header">Add Admin User</h4>
<?
if($userlogin==1 && $accessokformodule==1)
{
 if(isset($_POST['saveusers']))
{
$ipAdd=$_SERVER['REMOTE_ADDR'];
$user_ip=$_POST['user_ip'];
//$arr=explode(',', $user_ip);
//print_r($arr);

if($user_ip!= $ipAdd && $user_ip!= '')
        {?>
         <div class="alert alert-danger">
        	<a href="#" class="close" data-dismiss="alert">&times;</a>
        	<strong>Failed!</strong> Dont Allow this IP.
   	 </div> 
       <?}
else {

$user_login_name=$_POST['user_login_name'];
$sqlxy = "SELECT login_name FROM app_login_info  WHERE login_name ='$user_login_name'";
//print $sqlxy;
$mysqlresult1 = $mysqldblink->query($sqlxy);
if(mysqli_num_rows($mysqlresult1) >= 1){?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Login Name already exist.
    </div>

<?} else {

$uid=$_POST['uid'];
$user_login_name=$_POST['user_login_name'];
$user_full_name=$_POST['user_full_name'];
$user_pass=$_POST['user_pass'];
$user_mobile=$_POST['user_mobile'];
$user_ip=$_POST['user_ip'];
$user_location=$_POST['user_location'];
$user_reg_active=$_POST['user_reg_active'];
$savedetails=$_POST['savedetails'];
//$donexx=0;

if($savedetails=='save_users')
	{ 
$sqlx="INSERT INTO app_login_info (`login_name`, `login_pass`, `login_fullname`, `login_contact`,`login_ip`,`login_location`,`login_active`) VALUES ( '$user_login_name','$user_pass','$user_full_name', '$user_mobile','$user_ip','$user_location','$user_reg_active')";

$mysqlresult = $mysqldblink->query($sqlx);
if($mysqlresult){
//$donexx=1;
?>
   <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Admin Users Created Successfully.
    </div>
<?
}
}}}}
//if($donexx==0)
//{ 
?>

<form action=""  method="post" name="newadd" id="newadd"  >
<input type="hidden" name="savedetails" value="save_users">
<div class="row">
<div class="col-md-6">
Login Name : <input type="text" class="form-control" name="user_login_name" value="<?=$user_login_name?>" required >
</div>
<div class="col-md-6">
Full Name : <input type="text" class="form-control" name="user_full_name" value="<?=$user_full_name?>" required >
</div>
</div>
<div class="row">
<div class="col-md-6">
Mobile No: <input type="text" class="form-control" name="user_mobile" value="<?=$user_mobile?>" pattern="[0-9]{10}" title="10 digits Mobile No"required/>
</div>
<div class="col-md-6">
Password : <input type="password" class="form-control" id="user_pass"name="user_pass" value="<?=$user_pass?>" required/>
</div>
</div>
<div class="row">
<div class="col-md-6">
Location : <input type="text" class="form-control" name="user_location" value="<?=$user_location ?>" required >
</div>
<div class="col-md-6">
Active  :<select class="form-control" name="user_reg_active">
<option value="1" <?=$active?> >Active</option>
<option value="0" selected <?=$inactive?> >Inactive</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6">
Restricted IP (Separate by comma): (192.16.201.251,192.16.20.252) <input type="text" class="form-control" name="user_ip" value="<?=$user_ip ?>" >
</div>
</div>
<br/>
<button class="btn btn-default" name="saveusers" value="Save Details" onclick="save_user(); return false;">Create Admin  User</button>
</form>
<?//}?>

</div> 
<?
}
html_footer_to_show();
?>
