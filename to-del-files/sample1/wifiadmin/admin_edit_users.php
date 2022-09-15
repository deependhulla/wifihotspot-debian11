<?php
$submoduleid=21;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];

$savedetails=$_POST['savedetails'];
$type_wifi=$_REQUEST['type_wifi'];
$getu=$_REQUEST['getu'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
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
<h4 class="page-header">Update Admin Users | Uid : <?php echo $getuid;?></h4>

<?php
if($type_wifi=='del'){
$sqldel = "DELETE FROM `app_login_info` WHERE uid= $getuid" ;
$mysqldel = $mysqldblink->query($sqldel);
$sqlz="DELETE FROM `app_module_access` WHERE `login_name` = ".$getuid."";
#print " \n $sqldel <br> $sqlz\n";
$mysqlresultz = $mysqldblink->query($sqlz);


header("Location: admin_users.php?msgnow=del");
}

if($savedetails=='save_wifiuser') 
{

$sqlz="DELETE FROM `app_module_access` WHERE `login_name` = ".$getuid."";
#print " \n $sqldel <br> $sqlz\n";
$mysqlresultz = $mysqldblink->query($sqlz);

$totalnewaccess=array();
$totalnewaccessx=array();
$tx=0;
$legnd2="SELECT module_id,module_primary_id FROM `app_module_info`";
$mysqlegnd2 = $mysqldblink->query($legnd2);
while($mysqlrow2 = $mysqlegnd2->fetch_array()){
$xzid=$mysqlrow2['module_id'];
$xzidk="modaccess_".$xzid;
$xzidv=$_POST[$xzidk];
if($xzidv=="yes")
{

$totalnewaccessx[$tx]=$xzid;
$tx++;
echo $totalnewaccessx[$tx]=$mysqlrow2['module_primary_id'];
$tx++;
#print "<br>".$xzidk." --> ".$xzidv;

}
}

foreach($totalnewaccessx as $key=>$val) {   
  $totalnewaccess[$val] = true;
} 
$totalnewaccess = array_keys($totalnewaccess); 

for($tx=0;$tx<sizeof($totalnewaccess);$tx++)
{
if($totalnewaccess[$tx] !="")
{
#print "<br> NEW: ".$totalnewaccess[$tx];
$sqlx="INSERT INTO `wifihotspot`.`app_module_access` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `org_sname`, `module_id`, `login_name`) VALUES (NULL, NULL, '', CURRENT_TIMESTAMP, '', '', '".$totalnewaccess[$tx]."', '".$getuid."');";
#print "<br> $sqlx";
$mysqlegnd2 = $mysqldblink->query($sqlx);

}
}

$sqlx="UPDATE `app_login_info` SET ";
$sqlx=$sqlx."`login_name`= '". csx($_POST['user_login_name']) ."', " ;
$sqlx=$sqlx."`login_fullname`= '". csx($_POST['user_full_name']) ."', " ;
$sqlx=$sqlx."`login_pass`= '". csx($_POST['user_pass']) ."', " ;
$sqlx=$sqlx."`login_contact`= '". csx($_POST['user_mobile']) ."', " ;
$sqlx=$sqlx."`login_ip`= '". csx($_POST['user_ip']) ."', " ;
$sqlx=$sqlx."`login_location`= '". csx($_POST['user_location']) ."', " ;
$sqlx=$sqlx."`login_active`= '". csx($_POST['login_active']) ."' " ;
$sqlx=$sqlx." where `uid` =' ".$getuid."' " ;
$mysqlresultx=$mysqldblink->query($sqlx);
if($mysqlresultx){
header("Location: admin_users.php");
}

//Save over
}


$sqlxz="SELECT * FROM `app_login_info` Where `uid`= $getuid";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_array()){
//print_r($mysqlrow);
$getuid=$mysqlrow['uid'];
$user_login_name=$mysqlrow['login_name'];
$user_full_name=$mysqlrow['login_fullname'];
$user_pass=$mysqlrow['login_pass'];
$user_mobile=$mysqlrow['login_contact'];
$user_ip=$mysqlrow['login_ip'];
$user_location=$mysqlrow['login_location'];
$login_active=$mysqlrow['login_active'];
if($mysqlrow['login_active']=="1"){$active="selected";}
if($mysqlrow['login_active']=="0"){$inactive="selected";}

}
?>

<form action=""  method="post" name="newadd" id="newadd"  >
<input type="hidden" name="savedetails" value="save_wifiuser">

<div class="row">
<div class="col-md-6">
Login Name : <input type="text" class="form-control" name="user_login_name" value="<?php echo $user_login_name;?>" required >
</div>
<div class="col-md-6">
Full Name : <input type="text" class="form-control" name="user_full_name" value="<?php echo $user_full_name;?>" required >
</div>
</div>
<div class="row">
<div class="col-md-6">
Mobile No: <input type="text" class="form-control" name="user_mobile" value="<?php echo $user_mobile;?>" pattern="[0-9]{10}" title="10 digits Mobile No"required/>
</div>
<div class="col-md-6">
Password : <input type="password" class="form-control" id="user_pass"name="user_pass" value="<?php echo $user_pass;?>" required/>
</div>
</div>
<div class="row">
<div class="col-md-6">
Location : <input type="text" class="form-control" name="user_location" value="<?php echo $user_location; ?>" required >
</div>
<div class="col-md-6">
Active  :<select class="form-control" name="login_active">
<option value="1" <?php echo $active;?> >Active</option>
<option value="0" <?php echo $inactive;?> >Inactive</option>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6">
Restricted IP (Separate by comma): (192.16.201.251,192.16.20.252) <input type="text" class="form-control" name="user_ip" value="<?php echo $user_ip; ?>" >
</div>
</div>

<br/>

<!--- Modules Start from here -->
<div class="row">
<div class="col-md-6">
<?php
$gotmod=array();
$gm=0;
$sqx="SELECT DISTINCT `module_id` FROM `app_module_access` WHERE `login_name` = '".$getuid."' ";
$mysqlegnd1 = $mysqldblink->query($sqx);
while($mysqlrow = $mysqlegnd1->fetch_array()){
echo $gotmod[$gm]=$mysqlrow['module_id'];
$gm++;
}

$legnd1="SELECT module_id,module_sname FROM `app_module_info` WHERE `module_primary_id` = 0";
$mysqlegnd1 = $mysqldblink->query($legnd1);
while($mysqlrow = $mysqlegnd1->fetch_array()){
//print_r($mysqlrow);

$module_id=$mysqlrow['module_id'];
$module_sname=$mysqlrow['module_sname'];
?>

<fieldset class="scheduler-border">
    <legend class="scheduler-border">
<?php
//echo $module_id." -";
?>
<?php echo $module_sname;?></legend>
<?php
$legnd2="SELECT * FROM `app_module_info` WHERE `module_primary_id` = ".$module_id."";
$mysqlegnd2 = $mysqldblink->query($legnd2);
while($mysqlrow2 = $mysqlegnd2->fetch_array()){
$smodule_id=$mysqlrow2['module_id'];
$smodule_sname=$mysqlrow2['module_sname'];
$gcheck="";
for($gm=0;$gm<sizeof($gotmod);$gm++)
{
if($gotmod[$gm]==$smodule_id){$gcheck="checked";}
}
print "<br><input type=\"checkbox\" name=\"modaccess_".$smodule_id."\" value=\"yes\" ".$gcheck.">";
//echo $smodule_id." -";
print $smodule_sname;

}
?>
</fieldset>
<?php 
}
?>
</div>
</div>

<button class="btn btn-default" name="saveuser" value="Save Details" onclick="save_admin_user(); return false;">Save</button>
<input type="button" name="deluser" value="Delete" onClick="confirmdel(); return false;" class="btn btn-default">
</form>

<script>
function confirmdel(){
var y=confirm("Are you sure you want to delete?");
if(y==true){
window.location="admin_edit_users.php?uid=<?php echo $getuid;?>&type_wifi=del";
}
}
</script>

<?php
}
html_footer_to_show();
?>
