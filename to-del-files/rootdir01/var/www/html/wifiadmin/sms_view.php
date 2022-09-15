<?
$submoduleid=25;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
$search_mob=$_REQUEST['search_mob'];

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>

<div class="container">
<h4 class="page-header"><?=$moduletitle?></h4>
<form action="" method="POST" name="search_mobile" id="search_mobile">
<input type="hidden" name="search_mob" value="searchmob">
<div class="row">
<div class="col-md-2" style="vertical-align: bottom;">
Enter Mobile No. :
</div>
<div class="col-md-2">
<input type="text" class="form-control" name="uid" size=10 placeholder="Please Enter Mob No." required/></div>
<button class="btn btn-primary" name="search_mob_no" value="Search Details" onclick="go_mob(); return false;">Go</button>
</form>
<br>
<br>
</div>

<?
if($search_mob=='searchmob'){
$donexx=0;
$mysql="select u.uid,u.user_full_name,u.user_mobile,u.user_email,u.user_mac_address,u.user_reg_active,c.specialcode from mac_user_info as u, mac_code_info as c where u.uid=c.userid  and user_mobile=$getuid";
//print $mysql;
$mysqlresult = $mysqldblink->query($mysql);
if($mysqlrow = $mysqlresult->fetch_array()){
$donexx=1;

$gotuid=$mysqlrow['uid'];
$user_full_name=$mysqlrow['user_full_name'];
$user_mobile=$mysqlrow['user_mobile'];
$user_email=$mysqlrow['user_email'];
$user_reg_active=$mysqlrow['user_reg_active'];
$user_mac_address=$mysqlrow['user_mac_address'];
$user_special_code=$mysqlrow['specialcode'];
$user_reg_active=$mysqlrow['user_reg_active'];
if($user_reg_active==1){
$user_reg_active="<span style='color: green'>SMS Verified</span>";
}else{
$user_reg_active= "<span style='color: red'>SMS Not Verified</span>";
}
}else{
$donexx=0;
?>
<div class="alert alert-danger">
<strong>Failed!</strong> Mobile Number does not exist.
</div>
<?}} 
?>

<?
if($donexx==1){
?>
<div class="box-body">
<table class="table table-bordered">
<thead>
<tr>
<th>UID</th>
<th>Name</th>
<th>Mob No.</th>
<th>Email</th>
<th>SMS Code</th>
<th>MAC</th>
<th>SMS Verification</th>
</tr>
</thead>
<tbody>
<tr>
<td><?=$gotuid?></td>
<td><?=$user_full_name?></td>
<td><?=$user_mobile?></td>
<td><?=$user_email?></td>
<td><?=$user_special_code?></td>
<td><?=$user_mac_address?></td>
<td><?=$user_reg_active?></td>
</tr>            
</tbody>
</table>
</div>
</div>
<?
}
?>

<?
}
html_footer_to_show();
?>

