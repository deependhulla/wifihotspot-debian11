<?
$submoduleid=15;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<style>
.required:before {
    content: "*";
    color:red;
}
</style>
<div class="container">
<h4 class="page-header">Create Admin User</h4>
<? 
if(isset($_POST['savesip']))
{
$login_name=$_POST['login_name'];
if(empty($login_name))
{
$error_code="Please Enter Login Name.";
}
else{
$sqlxy = "SELECT login_name FROM app_login_info  WHERE login_name =$login_name";
//print $sqlxy;
$mysqlresultx = $mysqldblink->query($sqlxy);
if(mysqli_num_rows($mysqlresultx) >= 1){
 echo $login_name."Login Name already exist \n";
 //$error_code="Login Name already exist";
}
else
{
$error_code="Already Exist login name.";
}}}
 
$uid=$_POST['uid'];
$login_name=$_POST['login_name'];
$login_pass=$_POST['login_pass'];
$repass=$_POST['repass'];
$login_fullname=$_POST['login_fullname'];
$login_contact=$_POST['login_contact'];
$login_active=$_POST['login_active'];
$savedetails=$_POST['savedetails'];

if($savedetails=='saveapp')
	{
$sqlx="INSERT INTO `app_login_info` (`uid`, `logid`,`login_name`, `login_pass`, `login_fullname`, `login_contact`, `login_active`) VALUES ('', '','$login_name','$login_pass','$login_fullname','$login_contact', '$login_active')";
$mysqlresult = $mysqldblink->query($sqlx);
//header("Location: app_login_info.php");

if($mysqlresult){?>
   <div class="alert alert-success"><strong>Success!</strong> Your App User Created Successfully.
    </div>
<?
} else{ ?>
<div class="alert alert-danger" ><?=$error_code;?> </div>
<?
}
} 

?>
 <form action=""  method="post" name="newapp" id="newapp" onsubmit="return checkForm(this);">
 <input type="hidden" name="savedetails" value="saveapp" >

<div class="row">
<div class="required col-md-3">
Login Name :<input type="text"  class="form-control" name="login_name" value="<?=$login_name?>" required>
</div>
<div class="required col-md-3">
Full Name :<input type="text"  class="form-control" name="login_fullname" value="<?=$login_fullname?>" required >
</div>
</div>
<div class="row"> 
<div class="required col-md-3">
Password :<input type="password"  class="form-control" name="login_pass" value="<?=$login_pass?>" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.pwd2.pattern = this.value; " >
</div>
<div class="required col-md-3">
Re Password :<input type="password"  class="form-control" name="repass" value="<?=$repass?>" title="Please enter the same Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); ">
</div>
</div>
<div class="row">
<div class="required col-md-3">
Contact :<input type="text"  class="form-control" name="login_contact" value="<?=$login_contact?>" required>
</div>
<div class="col-md-3">
Active User :<select class="form-control" name="login_active">
<option value="1" <?=$active?> >Active</option>
<option value="0" <?=$inactive?> >Inactive</option>
</select>
</div>
</div><br/>
<button class="btn btn-default" name="savesip" value="Save Details" onclick="save_sip_user(); return false;">Create Admin User</button>
</form>        
</div>
<?
}
html_footer_to_show();
?>
