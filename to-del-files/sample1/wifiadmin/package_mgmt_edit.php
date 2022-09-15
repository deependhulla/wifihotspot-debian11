<?php
$submoduleid=11;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
 $getu=$_REQUEST['getu'];
$savedetails_accessplan=$_POST['savedetails_accessplan'];
$access_type=$_REQUEST['access_type'];

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{?>
<div class="container">
<h4 class="page-header">Update Package Management | UID :<?php echo $getuid; ?></h4>

<?php
if($savedetails_accessplan=='save_accessplan')
{
$mainsqlxx1="SELECT COUNT(*) as count, `value1`,`value2`,`package_active`,`uid` FROM `wifi_package_management` WHERE `value1`= '".strtoupper($_POST['value1'])."' AND `value2` = '".strtoupper($_POST['value2'])."' AND `package_active` = '1' AND `uid` != '".$getuid."'";

$mysqlresultxx1 = $mysqldblink->query($mainsqlxx1);
while($mysqlrowxx1 = $mysqlresultxx1->fetch_array()){
$count = $mysqlrowxx1['count'];
}
if($count >0){
?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Value1 and Value2 Already exist, Please enter unique Value1 and Value2.
    </div>

<?php
} else {


$sqlx="UPDATE `wifi_package_management` SET ";
$sqlx=$sqlx."`value1`= '". csx(strtoupper($_POST['value1'])) ."', " ;
$sqlx=$sqlx."`value2`= '". csx(strtoupper($_POST['value2'])) ."', " ;
$sqlx=$sqlx."`value3`= '". csx($_POST['value3']) ."', " ;
$sqlx=$sqlx."`access_plan_id`= '". csx($_POST['access_plan_id']) ."', " ;
$sqlx=$sqlx."`no_of_devices_allowed`= '". csx($_POST['no_of_devices_allowed']) ."', " ;
$sqlx=$sqlx."`package_active`= '". csx($_POST['package_active']) ."' " ;
$sqlx=$sqlx." where `uid` =' ".$getuid."' " ;
$mysqlresultx=$mysqldblink->query($sqlx);
if($mysqlresultx){?>
<div class="alert alert-success">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong> Your Package Updated Successfully.</strong>
    </div>
<?php

}else{?>
<div class="alert alert-danger">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Your Package Cannot be Updated Successfully.</strong>
    </div>

<?php
}
}
}

$sqlxz="SELECT `uid`,`value1`,`value2`,`value3`,`access_plan_id`,`no_of_devices_allowed`,`package_active` FROM `wifi_package_management` Where `uid`= $getuid";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_array()){
 $getuid=$mysqlrow['uid'];
 $value1=$mysqlrow['value1'];
 $value2=$mysqlrow['value2'];
 $value3=$mysqlrow['value3'];
 $access_plan_id=$mysqlrow['access_plan_id'];
 $no_of_devices_allowed=$mysqlrow['no_of_devices_allowed'];
 $package_active=$mysqlrow['package_active'];
 if($package_active=="1"){$active="selected";}
 if($package_active=="0"){$inactive="selected";}

}


if($access_type == 'delete')
{
//echo $getuid;
$sqldel = "DELETE FROM `wifi_package_management` WHERE uid = $getuid";
$mysqldel = $mysqldblink->query($sqldel);
header("Location: package_mgmt.php");
}

$mainsql="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_1_TEXT'";

$mysqlresult = $mysqldblink->query($mainsql);
while($mysqlrow = $mysqlresult->fetch_array()){
$val1 = $mysqlrow['msg_data'];
}

$mainsql1="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_2_TEXT'";

$mysqlresult1 = $mysqldblink->query($mainsql1);
while($mysqlrow1 = $mysqlresult1->fetch_array()){
$val2 = $mysqlrow1['msg_data'];
}

$mainsql3="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_3_TEXT'";
$mysqlresult3 = $mysqldblink->query($mainsql3);
while($mysqlrow3 = $mysqlresult3->fetch_array()){
$val3 = $mysqlrow3['msg_data'];
}

?>

<form action=""  method="post" name="newadd" id="newadd" >
 <input type="hidden" name="savedetails_accessplan" value="save_accessplan" >

<div class="row">
<div class="col-md-6">Value1(<?php echo $val1;?>) :
<input type="text"  class="form-control" name="value1" value="<?php echo $value1; ?>" required/></div>
<div class="col-md-6">Value2(<?php echo $val2;?>) :
<input type="text"  class="form-control" name="value2" value="<?php echo $value2; ?>" required/></div>

<div class="col-md-6">
Access Plan :
<select class="form-control" name="access_plan_id" required>
<option value="" selected>Select Access Plan</option>
<?php

$sqlxz="SELECT uid,user_access_plan_name FROM wifi_access_plan where `access_plan_active`=1";
$mysqlresultxz = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresultxz->fetch_array()){
$uidxx=$mysqlrow['uid'];
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
$selok="";
if($access_plan_id==$mysqlrow['uid']){$selok="selected";}
echo "<option value=$uidxx ".$selok."> $user_access_plan_name</option>";
}
?>
</select>
</div>
<div class="col-md-6">Value 3(<?php echo $val3;?>) :
<input type="text"  class="form-control" name="value3" value="<?php echo $value3;?>" required/></div>

<div class="col-md-6">Number of Devices Allowed :
<input type="text"  class="form-control" name="no_of_devices_allowed" value="<?php echo $no_of_devices_allowed; ?>" required/></div>

<div class="col-md-6">Package Active  :<select class="form-control" name="package_active">
<option value="1" <?php echo $active;?> >Active</option>
<option value="0" <?php echo $inactive;?> >Inactive</option>
</select>
</div>
</div>


<br>
<button   class="btn btn-default" name="saveaccessplan" value="Save Details" onclick="save_access_plan(); return false;">Save</button>
<?php 
if($getuid!='0'){
?>
<a href="package_mgmt_edit.php?uid=<?php echo $getuid;?>&access_type=delete" class="btn btn-default" id="del_accessplan" onclick="return confirm('Do you really want to delete this?')">Delete</a>
<?php 
}
?>
</form>        
<br>
<script type="text/javascript">
$('#popoverData').popover({ 
trigger: "click", 
html: true,
animation: true,
placement: 'bottom'
});

$('#popoverData_mb').popover({ 
trigger: "click", 
html: true,
animation: true,
placement: 'bottom'
});

$('#popoverData_mb_reset').popover({ 
trigger: "click", 
html: true,
animation: true,
placement: 'bottom'
});

</script>

</div>

<?php
}
html_footer_to_show();
?>
