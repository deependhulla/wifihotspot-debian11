<?php
$submoduleid=11;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}

if($userlogin==1 && $accessokformodule==1)
{?>
 <div class="container">
<h4 class="page-header">Add Access Plan</h4>
<?php
 $uid=$_POST['uid'];
 $user_access_plan_name=$_POST['user_access_plan_name'];
 $user_ip_notallowed_list=$_POST['user_ip_notallowed_list'];
 $validity_period_in_mins=$_POST['validity_period_in_mins'];
 $traffic_limit_in_mb=$_POST['traffic_limit_in_mb'];
 $traffic_reset_limit_in_mb=$_POST['traffic_reset_limit_in_mb'];
 $basic_upload_max_speed_kbps=$_POST['basic_upload_max_speed_kbps'];
 $basic_download_max_speed_kbps=$_POST['basic_download_max_speed_kbps'];
 $traffic_reset_period=$_POST['traffic_reset_period'];
 $plan_price=$_POST['plan_price'];
 $special_ip_list=$_POST['special_ip_list'];
 $access_plan_active=$_POST['access_plan_active'];
 $internal_notes=$_POST['internal_notes']; 
 $savedetails_accessplan=$_POST['savedetails_accessplan']; 

if($basic_upload_max_speed_kbps=="") {$basic_upload_max_speed_kbps=0;}
if($basic_download_max_speed_kbps==""){$basic_download_max_speed_kbps=0;}
 if($savedetails_accessplan=='save_accessplan')
	{
$sqlx="INSERT INTO `wifi_access_plan`(`user_access_plan_name`, `user_ip_notallowed_list`, `validity_period_in_mins`, `basic_upload_max_speed_kbps`, `basic_download_max_speed_kbps`, `special_ip_list`, `access_plan_active`, `internal_notes`, `traffic_limit_in_mb`, `traffic_reset_limit_in_mb`, `traffic_reset_period`, `plan_price`) VALUES('$user_access_plan_name', '$user_ip_notallowed_list', '$validity_period_in_mins', '$basic_upload_max_speed_kbps', '$basic_download_max_speed_kbps', '$special_ip_list', '$access_plan_active', '$internal_notes', '$traffic_limit_in_mb', '$traffic_reset_limit_in_mb', '$traffic_reset_period', '$plan_price');";
#print "$sqlx";
$mysqlresult = $mysqldblink->query($sqlx);

if($mysqlresult){?>
   <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Access Plan Created Successfully.
    </div>
<?php
} else{ ?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Your Access Plan Cannot be Created Successfully.
    </div>
    <?php
}
}


$sqlxz11="SELECT `msg_data` FROM `config_info` Where `type_of_msg`= 'DEFAULT_UPLOAD_IN_KBPS'";
$mysqlresult11 = $mysqldblink->query($sqlxz11);
while($mysqlrow11 = $mysqlresult11->fetch_array()){
$upload_kbps_config=$mysqlrow11['msg_data'];
}

$sqlxz112="SELECT `msg_data` FROM `config_info` Where `type_of_msg`= 'DEFAULT_DOWNLOAD_IN_KBPS'";
$mysqlresult112 = $mysqldblink->query($sqlxz112);
while($mysqlrow112 = $mysqlresult112->fetch_array()){
$download_kbps_config=$mysqlrow112['msg_data'];
}
 
?> 

<form action=""  method="post" name="newadd" id="newadd" >
 <input type="hidden" name="savedetails_accessplan" value="save_accessplan" >
<div class="row">
<div class="col-md-8">Plan Name :
<input type="text"  class="form-control" name="user_access_plan_name" value="<?php echo $user_access_plan_name; ?>" required/></div>
<div class="col-md-4">Active  :<select class="form-control" name="access_plan_active">
<option value="1" <?php echo $active;?> >Active</option>
<option value="0" selected <?php echo $inactive;?> >Inactive</option>
</select>
</div>
</div>
<!--<div class="row">
<div class="col-md-4">Basic Upload Speed<input type="number"  class="form-control" name="basic_upload_max_speed_kbps"  value="<?php echo $basic_upload_max_speed_kbps;?>"></div>
<div class="col-md-4">Basic Download Speed<input type="number"  class="form-control" name="basic_download_max_speed_kbps" value="<?php echo $basic_download_max_speed_kbps;?>"></div>
<div class="col-md-4">Traffic Limit<input type="number"  class="form-control" name="traffic_limit_in_mb"  value="<?php echo $traffic_limit_in_mb; ?>"></div>
</div>-->
<div class="row">
<div class="col-md-6">Valid Period (in minutes):
<?php

$htmltable_days='
                                    <table>
                                    <tr>
                                    <th>Days</th><th>Mins</th>
                                    </tr>
                                    <tr>
                                    <td>1 Day-</td><td>1440 Min</td>
                                    </tr>
                                    <tr>
                                    <td>2 Days-</td><td>2880 Min</td>
                                    </tr>
                                    <tr>
                                    <td>7 Days-</td><td>10080 Min</td>
                                    </tr>
                                    <tr>
                                    <td>15 Days-</td><td>21600 Min</td>
                                    </tr>
                                    <tr>
                                    <td>30 Days-</td><td>43200 Min</td>
                                    </tr>
                                    <tr>      
                                    <td>3 Months-&nbsp; </td><td>129600 Min</td>
                                    </tr>
                                    <tr>                               
                                    <td>6 Months-</td><td>259200 Min</td>
                                    </tr>
                                    <tr>
                                    <td>9 Months-</td><td>388800 Min</td>
                                    </tr>
                                    <tr>                                
                                    <td>1 Year-</td><td>525600 Min</td>
                                    </tr>
                                    <tr>                                 
                                    <td>5 Year-</td><td>2628000 Min</td>
                                    </tr>
                                    <tr>
                                    <td>10 Year-</td><td>5256000 Min</td>
                                    </tr>
                                </table>';


$htmltable_mblimit='
                                    <table>
                                    <tr>
                                    <th>GB</th><th>MB</th>
                                    </tr>
                                    <tr>
                                    <td>1 GB-</td><td>1024 MB</td>
                                    </tr>
                                    <tr>
                                    <td>2 GB-</td><td>2048 MB</td>
                                    </tr>
                                    <tr>
                                    <td>3 GB-</td><td>3072 MB</td>
                                    </tr>
                                    <tr>
                                    <td>5 GB-</td><td>5120 MB</td>
                                    </tr>
                                    <tr>
                                    <td>10 GB-</td><td>10240 MB</td>
                                    </tr>
                                    <tr>      
                                    <td>15 GB-&nbsp; </td><td>15360 MB</td>
                                    </tr>
                                    <tr>                               
                                    <td>25 GB-</td><td>25600 MB</td>
                                    </tr>
                                    <tr>
                                    <td>50 GB-</td><td>51200 MB</td>
                                    </tr>
                                    <tr>                                
                                    <td>100 GB-</td><td>102400 MB</td>
                                    </tr>
                                </table>';


?>
<a id="popoverData" class="glyphicon glyphicon-question-sign" href="#" data-content="<?php echo $htmltable_days;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>

<input type="number" class="form-control" name="validity_period_in_mins" value="<?php echo $validity_period_in_mins; ?>" pattern="[0-9]" required/></div>
<div class="col-md-6">Traffic Limit For Valid Period in MB (0 Means Unlimited):
<a id="popoverData_mb" class="glyphicon glyphicon-question-sign" href="#" data-content="<?php echo $htmltable_mblimit;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>

<input type="number"  class="form-control" name="traffic_limit_in_mb" value="<?php echo $traffic_limit_in_mb;?>" pattern="[0-9]" required/></div>
</div>
                            
<div class="row">
<div class="col-md-6">Traffic Reset Limit For Valid Period in Days (0 Means No Cap):<input type="number"  class="form-control" name="traffic_reset_period" value="<?php echo $traffic_reset_period;?>" pattern="[0-9]" required/></div>
<div class="col-md-6">Traffic Reset Limit in MB (0 Means No Cap):
<a id="popoverData_mb_reset" class="glyphicon glyphicon-question-sign" href="#" data-content="<?php echo $htmltable_mblimit;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>
<input type="number"  class="form-control" name="traffic_reset_limit_in_mb" value="<?php echo $traffic_reset_limit_in_mb;?>" pattern="[0-9]" required/></div>
</div>

<div class="row">
<!--
<div class="col-md-6">Upload Speed (kbps):
<?php
if($basic_upload_max_speed_kbps == ''){
?>
<input type="number"  class="form-control" name="basic_upload_max_speed_kbps" value="<?php echo $upload_kbps_config;?>" pattern="[0-9]" required/>
<?php
} else {
?>
<input type="number"  class="form-control" name="basic_upload_max_speed_kbps" value="<?php echo $basic_upload_max_speed_kbps;?>" pattern="[0-9]" required/>
<?php
}
?>
-->
<div class="col-md-6">Download Speed (kbps):
<?php
if($basic_download_max_speed_kbps == ''){
?>
<input type="number"  class="form-control" name="basic_download_max_speed_kbps" value="<?php echo $download_kbps_config;?>" pattern="[0-9]" required/>
<?php
} else {
?>
<input type="number"  class="form-control" name="basic_download_max_speed_kbps" value="<?php echo $basic_download_max_speed_kbps; ?>" pattern="[0-9]" required/>
<?php
}
?>
</div>


<div class="row">
<div class="col-md-6">Plan Price In INR (0 Means Free):<input type="number"  class="form-control" name="plan_price" value="<?php echo $plan_price;?>" pattern="[0-9]" required/></div>
</div>
<div class="col-md-6">Internal Notes:
<textarea class="form-control" rows="10" name="internal_notes" ><?php echo $internal_notes;?></textarea>
</div>
<!--
<div class="row">
<div class="col-md-6">IP-not-allowed:
<label for="user_ip_notallowed_list"></label>
  <textarea class="form-control" name="user_ip_notallowed_list"  value=""rows="5" id="user_ip_notallowed_list"><?php echo $user_ip_notallowed_list;?></textarea>
</div>
  <div class="col-md-6">Special IP List:
  <label for="special_ip_list"></label>
  <textarea class="form-control" name="special_ip_list"  value=""rows="5" id="special_ip_list"><?php echo $special_ip_list; ?></textarea>
</div>
</div>
-->
</div>
<br>
<button class="btn btn-default" name="saveaccessplan" value="Save Details" onclick="save_access_plan(); return false;">Create Access Plan</button>
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
