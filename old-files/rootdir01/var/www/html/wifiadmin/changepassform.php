<?
$submoduleid=0;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
$accessokformodule=1;
if($userlogin==1 && $accessokformodule==1)
{
$mainfun = $_POST['mainfun'];
?>
<div class="container">
<h4 class="page-header">Change Password for <?=$userloginname?></h4>

<?
if(isset($_POST['change_pass']))
{
$newpass=$_POST['newpass'];
$confpass=$_POST['login_pass'];
if($newpass!="" && $confpass!=""){
if($newpass == $confpass){
$sqlxz1="UPDATE `app_login_info` SET ";
$sqlxz1=$sqlxz1."`login_pass`= '". csx($_POST['login_pass']) ."' " ;
$sqlxz1=$sqlxz1." where `login_name` = '".$userloginname."'" ;
$mysqldblink->query($sqlxz1);
//print $sqlxz1;
//echo "New Password Updated";
?>
<div class="alert alert-danger" >New Password Updated </div>
<?
}else {
?>
<div class="alert alert-danger" >New Password & Confirmed Password does not match </div>
<?
}
}}
?>
<form action=""  method="post" name="mypass" id="mypass">
<input type="hidden" name="mainfun" value="changepass">

<div class="row">
<div class="col-md-4">
New Password : <input type="password" class="form-control" name="newpass" id="newpass" value="">
</div>
<div class="col-md-4">
Confirm Password : <input type="password" class="form-control" name="login_pass" id="login_pass" value="" >
</div>
</div><br/>
<input type="submit" name="change_pass" id="change_pass" value="Change Password" class="btn btn-default" >
</form>
</div>
<?
}
html_footer_to_show();
?>
