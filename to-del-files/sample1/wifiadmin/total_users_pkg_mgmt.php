<?php
$submoduleid=24;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
//echo "----".$getuid;
{
?>
<?php
$mysqlx="SELECT DISTINCT u.uid,u.user_full_name,u.user_mobile,u.user_email,u.user_mac_address,p.package_uid, p.mac_uid FROM mac_user_info as u LEFT JOIN wifi_live_plans as p ON u.uid=p.mac_uid where package_uid='".$getuid."' ";
#print " $mysqlx ";
$mysqlresult = $mysqldblink->query($mysqlx);
?>
<div class="container">
<h4 class="page-header">Registered User of Package UID No.</h4>
<p align="right"><button class="btn btn-info" onclick="window.history.go(-1)">Back</button></p>
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th>Device UID</th>
<th>Name</th>
<th>Mob No.</th>
<th>Email</th>
<th>MAC</th>
</tr>
</thead>
<?php
while($mysqlrow = $mysqlresult->fetch_array()){
#print_r($mysqlrow);
$uid=$mysqlrow['uid'];
$user_full_name=$mysqlrow['user_full_name'];
$user_mobile=$mysqlrow['user_mobile'];
$user_email=$mysqlrow['user_email'];
$user_mac_address=$mysqlrow['user_mac_address'];
?>
<tr>
<td><a href='plan_activation.php'><?php echo $uid;?></a></td>
<td><?php echo $user_full_name;?></td>
<td><a href='wifi_edit_users.php?uid=<?php echo $uid; ?>'><?php echo $user_mobile;?></a></td>
<td><?php echo $user_email;?></td>
<td><a href='index.php?rtype=macview&macid=<?php echo $user_mac_address;?>'><?php echo $user_mac_address;?></a></td>
</tr>
</div>
</div>
<?php
}
?>
<?php
}
html_footer_to_show();
?>

