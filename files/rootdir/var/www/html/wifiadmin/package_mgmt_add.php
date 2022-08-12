<?php
$submoduleid=11;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}

if($userlogin==1 && $accessokformodule==1)
{?>
 <div class="container">
<h4 class="page-header">Add New Package</h4>
<?php
 $uid=$_POST['uid'];
 $value1=$_POST['value1'];
 $value2=$_POST['value2'];
 $value3=$_POST['value3'];
 $value2=strtoupper($value2);
 $value1=strtoupper($value1); 
 $access_plan_id=$_POST['access_plan_id'];
 $no_of_devices_allowed=$_POST['no_of_devices_allowed'];
 $package_active=$_POST['package_active'];
 $savedetails_accessplan=$_POST['savedetails_accessplan']; 
 
 if($savedetails_accessplan=='save_accessplan')
	{

$mainsqlxx="SELECT COUNT(*) as count, `value1`,`value2`,`package_active` FROM `wifi_package_management` WHERE `value1`= '".$value1."' AND `value2` = '".$value2."' AND `package_active` = '1'";

$mysqlresultxx = $mysqldblink->query($mainsqlxx);
while($mysqlrowxx = $mysqlresultxx->fetch_array()){
$count = $mysqlrowxx['count'];
}
if($count >0){
?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Value1 and Value2 Already exist, Please enter unique Value1 and Value2.
    </div>

<?php
} else {

$sqlx="INSERT INTO `wifi_package_management`(`value1`, `value2`, `value3`,`access_plan_id`, `no_of_devices_allowed`, `package_active`) VALUES('$value1', '$value2', '$value3','$access_plan_id', '$no_of_devices_allowed', '$package_active');";
#print " $sqlx ";

$mysqlresult = $mysqldblink->query($sqlx);

if($mysqlresult){?>
   <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Package Created Successfully.
    </div>
<?php
} else{ ?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Your Cannot be Created Successfully.
    </div>
    <?php
}
}
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
<input type="text"  class="form-control" name="value1" value="<?php echo $value1;?>" required/></div>
<div class="col-md-6">Value2(<?php echo $val2;?>) :
<input type="text"  class="form-control" name="value2" value="<?php echo $value2;?>" required/></div>

<div class="col-md-6">
Access Plan :
<select id="access_plan_id" class="form-control" name="access_plan_id" required>
<option value="" selected>Select Access Plan</option>
<?php
$sqlxz="SELECT uid,user_access_plan_name FROM wifi_access_plan where `access_plan_active`=1";
$mysqlresultxz = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresultxz->fetch_array()){
$uidxx=$mysqlrow['uid'];
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
//echo "<option value='$uidxx'>shr</option>";
echo "<option value='$uidxx'>$user_access_plan_name</option>";
}
?>
</select>
</div>
<div class="col-md-6">Value 3(<?php echo $val3;?>) :
<input type="text"  class="form-control" name="value3" value="<?php echo $value3;?>" required/></div>

<div class="col-md-6">Number of Devices Allowed :
<?php 
if($no_of_devices_allowed == ''){
?>
<input type="text"  class="form-control" name="no_of_devices_allowed" value="2" required/></div>
<?php
} else {
?>
<input type="text"  class="form-control" name="no_of_devices_allowed" value="<?php echo $no_of_devices_allowed;?>" required/></div>
<?php
}
?>

<div class="col-md-6">Package Active  :<select class="form-control" name="package_active">
<option value="1" selected <?php echo $active;?> >Active</option>
<option value="0"  <?php echo $inactive;?> >Inactive</option>
</select>
</div>
</div>

<br>
<button class="btn btn-default" name="saveaccessplan" value="Save Details" onclick="save_access_plan(); return false;">Create New Package</button>
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
