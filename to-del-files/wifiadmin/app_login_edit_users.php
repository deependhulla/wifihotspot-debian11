<?
$submoduleid=15;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}

$savefun=$_POST['savefun'];
$repass=$_POST['repass'];
$action=$_REQUEST['action'];
if($savefun==""){$savefun="showform";}

$login_name=$_POST['login_name'];
$login_pass=$_POST['login_pass'];
$login_fullname=$_POST['login_fullname'];
$login_contact=$_POST['login_contact'];
$login_active=$_POST['login_active'];

if($userlogin==1 && $accessokformodule==1)
{
if($_GET['uid']!="")
{
$gotuidx= $_GET['uid'];
}
$mysql="SELECT `uid`, `login_name`,`login_pass`, `login_fullname`, `login_contact`,`login_active` FROM `app_login_info` where `uid` = ".$gotuidx;
$mysqlresult = $mysqldblink->query($mysql);

while($mysqlrow = $mysqlresult->fetch_array()){
//print_r($mysqlrow);
$gotuidx=$mysqlrow['uid'];
$login_name=$mysqlrow['login_name'];
$login_pass=$mysqlrow['login_pass'];
$login_fullname=$mysqlrow['login_fullname'];
$login_contact=$mysqlrow['login_contact'];
$login_active=$mysqlrow['login_active'];

if($mysqlrow['login_active']=="1"){$active="selected";}
if($mysqlrow['login_active']=="0"){$inactive="selected";}
}
?>
<div class="container">
<h4 class="page-header">Wifi App Users |  &nbsp; User ID:<?=$gotuidx;?></h4>

<?
if($savefun=="savedetails")
{ 
//if($login_pass!="" && $repass!=""){
//if($login_pass == $repass){
$sqlb="UPDATE `app_login_info` SET ";
$sqlb=$sqlb."`login_name`= '". csx($_POST['login_name']) ."', " ;
$sqlb=$sqlb."`login_pass`= '". csx($_POST['login_pass']) ."', " ;
$sqlb=$sqlb."`login_fullname`= '". csx($_POST['login_fullname']) ."', " ;
$sqlb=$sqlb."`login_contact`= '". csx($_POST['login_contact']) ."', " ;
$sqlb=$sqlb."`login_active`= '". csx($_POST['login_active']) ."' " ;
$sqlb=$sqlb." where `uid` =' ".$gotuidx."' " ;
$mysqlresult=$mysqldblink->query($sqlb);
//header("Location: app_login_info.php");
if($mysqlresult){?>
   <div class="alert alert-success"> Your User Details Updated Successfully. </div>
<?
} else{ ?>
<div class="alert alert-danger" >User Already Exist.</div>
<?
}}
?>

<? 
if($action=='delete')
{
$sqldelete = "DELETE FROM app_login_info WHERE uid ='$gotuidx'";
//echo $sqldelete;
$mysqldelete=$mysqldblink->query($sqldelete);
header("Location: app_login_info.php");
} 
?>
<style>
.required:before {
    content: "*";
    color:red;
}
</style>

<?php

if($savefun=="showform")
{
//  form show
?>

<form action=""  method="post" name="myform" id="myform">
<input type="hidden" name="savefun" value="savedetails">

<div class="row">
<div class="required col-md-3">
Login Name : <input type="text" class="form-control" name="login_name" value="<?=$login_name?>" required>
</div>
<div class="required col-md-3">
Full Name : <input type="text" class="form-control" name="login_fullname" value="<?=$login_fullname?>" >
</div>
</div>
<div class="row">
<div class="required col-md-3">
Password : <input type="password" class="form-control" id="login_pass" name="login_pass" value="<?=$login_pass?>" title="Password must contain at least 6 characters, including UPPER/lowercase and numbers" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.pwd2.pattern = this.value;">
</div>
<div class="required col-md-3">
Re Password :<input type="password"  class="form-control" id="repass" name="repass" value="<?=$repass?>" title="Please enter the same Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" onchange=" this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); ">
</div>
</div>
<div class="row">
<div class="required col-md-3">
Contact : <input type="text" class="form-control" name="login_contact" value="<?=$login_contact ?>" >
</div>
<div class="col-md-3">
Active User :<select class="form-control" name="login_active">
<option value="1" <?=$active ?> >Active </option>
<option value="0" <?=$inactive ?> >InActive </option>
</select>
</div>
</div><br/>
<button type="button" name="saveusers" value="Save User" class="btn btn-default" onclick="document.myform.submit();return false;"><span>Save</span></button>
<a href="app_login_edit_users.php?uid=<?=$gotuidx?>&action=delete" class="btn btn-default" onclick="return confirm('Do you really want to delete this?')">Delete</a>
</form>
<?
}
// form show over
?>
</div>

<?
}
html_footer_to_show();
?>
