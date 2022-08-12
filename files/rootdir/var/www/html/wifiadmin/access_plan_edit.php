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
<h4 class="page-header">Update Access Plan | UID :<?php echo $getuid; ?></h4>

<?php
if($savedetails_accessplan=='save_accessplan')
{
if($_POST['basic_upload_max_speed_kbps']==""){$_POST['basic_upload_max_speed_kbps']=0;}
if($_POST['basic_download_max_speed_kbps']==""){$_POST['basic_download_max_speed_kbps']=0;}
$sqlx="UPDATE `wifi_access_plan` SET ";
$sqlx=$sqlx."`user_access_plan_name`= '". csx($_POST['user_access_plan_name']) ."', " ;
$sqlx=$sqlx."`user_ip_notallowed_list`= '". csx($_POST['user_ip_notallowed_list']) ."', " ;
$sqlx=$sqlx."`validity_period_in_mins`= '". csx($_POST['validity_period_in_mins']) ."', " ;
$sqlx=$sqlx."`traffic_limit_in_mb`= '". csx($_POST['traffic_limit_in_mb']) ."', " ;
$sqlx=$sqlx."`traffic_reset_limit_in_mb`= '". csx($_POST['traffic_reset_limit_in_mb']) ."', " ;
$sqlx=$sqlx."`traffic_reset_period`= '". csx($_POST['traffic_reset_period']) ."', " ;
$sqlx=$sqlx."`basic_upload_max_speed_kbps`= '". csx($_POST['basic_upload_max_speed_kbps']) ."', " ;
$sqlx=$sqlx."`basic_download_max_speed_kbps`= '". csx($_POST['basic_download_max_speed_kbps']) ."', " ;
$sqlx=$sqlx."`plan_price`= '". csx($_POST['plan_price']) ."', " ;
$sqlx=$sqlx."`basic_upload_max_speed_kbps`= '". csx($_POST['basic_upload_max_speed_kbps']) ."', " ;
$sqlx=$sqlx."`basic_download_max_speed_kbps`= '". csx($_POST['basic_download_max_speed_kbps']) ."', " ;
$sqlx=$sqlx."`special_ip_list`= '". csx($_POST['special_ip_list']) ."' ," ;
$sqlx=$sqlx."`access_plan_active`= '". csx($_POST['access_plan_active']) ."' ," ;
$sqlx=$sqlx."`internal_notes`= '". csx($_POST['internal_notes']) ."' " ;
$sqlx=$sqlx." where `uid` =' ".$getuid."' " ;
$mysqlresultx=$mysqldblink->query($sqlx);
#print "$sqlx";
if($mysqlresultx){?>
<div class="alert alert-success">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong> Your Access Plan Updated Successfully.</strong>
    </div>
<?php

}else{?>
<div class="alert alert-danger">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Your Access Plan Cannot be Updated Successfully.</strong>
    </div>

<?php
}
}

$sqlxz="SELECT `uid`,`user_access_plan_name`,`user_ip_notallowed_list`,`validity_period_in_mins`,`traffic_limit_in_mb`,`traffic_reset_limit_in_mb`,`traffic_reset_period`,`basic_upload_max_speed_kbps`,`basic_download_max_speed_kbps`,`plan_price`,`special_ip_list`,`access_plan_active`,`internal_notes` FROM `wifi_access_plan` Where `uid`= $getuid";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_array()){
$getuid=$mysqlrow['uid'];
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
 $user_ip_notallowed_list=$mysqlrow['user_ip_notallowed_list'];
 $validity_period_in_mins=$mysqlrow['validity_period_in_mins'];
 $traffic_limit_in_mb=$mysqlrow['traffic_limit_in_mb'];
 $traffic_reset_limit_in_mb=$mysqlrow['traffic_reset_limit_in_mb'];
 $traffic_reset_period=$mysqlrow['traffic_reset_period'];
 $basic_upload_max_speed_kbps=$mysqlrow['basic_upload_max_speed_kbps'];
 $basic_download_max_speed_kbps=$mysqlrow['basic_download_max_speed_kbps'];
 $plan_price=$mysqlrow['plan_price'];
 $special_ip_list=$mysqlrow['special_ip_list'];
 $access_plan_active=$mysqlrow['access_plan_active'];
 $internal_notes=$mysqlrow['internal_notes']; 
 if($mysqlrow['access_plan_active']=="1"){$active="selected";}
 if($mysqlrow['access_plan_active']=="0"){$inactive="selected";}

}


if($access_type == 'delete')
{
//echo $getuid;
$sqldel = "DELETE FROM `wifi_access_plan` WHERE uid = $getuid";
$mysqldel = $mysqldblink->query($sqldel);
header("Location: access_plan.php");
}
?>

<form action=""  method="post" name="newadd" id="newadd" >
 <input type="hidden" name="savedetails_accessplan" value="save_accessplan" >
<div class="row">
<div class="col-md-8">Plan Name :<input type="text"  class="form-control" name="user_access_plan_name" value="<?php echo $user_access_plan_name; ?>" required/></div>
<div class="col-md-4">
<?php
if($getuid!='0')
{
?>
Active  :<select class="form-control" name="access_plan_active">
<option value="1" <?php echo $active; ?> >Active</option>
<option value="0" <?php echo $inactive;?> >Inactive</option>
</select>
<?php
}
else
{
?>
Active : <br> <font color=green style="font-size:18px">Yes</font>
<?php
}
?>
</div>
</div>
<!--<div class="row">
<div class="col-md-4">Basic Upload Speed<input type="number"  class="form-control" name="basic_upload_max_speed_kbps"  value="<?php echo $basic_upload_max_speed_kbps; ?>"></div>
<div class="col-md-4">Basic Download Speed<input type="number"  class="form-control" name="sipextpassword" id="password" value="<?php echo $basic_download_max_speed_kbps;?>"></div>
<div class="col-md-4">Traffic Limit<input type="number"  class="form-control" name="sipextpassword" id="password" value="<?php echo $traffic_limit_in_mb; ?>"></div>
</div>-->
<?php
$htmltable='
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


<div class="row">
<div class="col-md-6">Valid Period (in minutes):
<a id="popoverData" class="glyphicon glyphicon-question-sign" href="#" data-content="<? echo $htmltable;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>

<input type="number"  class="form-control" name="validity_period_in_mins" value="<?php echo $validity_period_in_mins; ?>" pattern="[0-9]"></div>
<div class="col-md-6">Traffic Limit For Valid Period in MB (0 Means Unlimited):
<a id="popoverData_mb" class="glyphicon glyphicon-question-sign" href="#" data-content="<?php echo $htmltable_mblimit;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>
<input type="number"  class="form-control" name="traffic_limit_in_mb" value="<?php echo $traffic_limit_in_mb;?>" pattern="[0-9]"></div>
</div>

<div class="row">
<div class="col-md-6">Traffic Reset Limit For Valid Period in Days (0 Means No Cap):
<a id="popoverData_mb_reset" class="glyphicon glyphicon-question-sign" href="#" data-content="<?php echo $htmltable_mblimit;?>" rel="popover" data-placement="bottom" data-trigger="hover"></a>
<input type="number"  class="form-control" name="traffic_reset_period" value="<?php echo $traffic_reset_period;?>" pattern="[0-9]" required/></div>
<div class="col-md-6">Traffic Reset Limit in MB (0 Means No Cap):<input type="number"  class="form-control" name="traffic_reset_limit_in_mb" value="<?php echo $traffic_reset_limit_in_mb;?>" pattern="[0-9]"></div>
</div>

<div class="row">
<!--
<div class="col-md-6">Upload Speed (kbps):
<input type="number"  class="form-control" name="basic_upload_max_speed_kbps" value="<?php echo $basic_upload_max_speed_kbps;?>" pattern="[0-9]" required/></div>
-->
<div class="col-md-6">Download Speed (kbps):<input type="number"  class="form-control" name="basic_download_max_speed_kbps" value="<?php echo $basic_download_max_speed_kbps;?>" pattern="[0-9]"></div>


<div class="row">
<div class="col-md-6">Plan Price In INR (0 Means Free):<input type="number"  class="form-control" name="plan_price" value="<?php echo $plan_price;?>" pattern="[0-9]" required/></div>
</div>
<div class="col-md-6">Internal Notes:
<textarea class="form-control" rows="10" name="internal_notes" ><?php echo $internal_notes;?></textarea>
<!--<input type="text"  class="form-control" name="internal_notes" value="<?php echo $internal_notes;?>"></div>-->
</div>
<!--
<div class="row">
<div class="col-md-6">IP-not-allowed:
<label for="user_ip_notallowed_list"></label>
<textarea class="form-control" name="user_ip_notallowed_list"  value=""rows="5" id="user_ip_notallowed_list"><?php echo $user_ip_notallowed_list; ?></textarea>
</div>

<div class="col-md-6">Special IP List:
<label for="special_ip_list"></label>
<textarea class="form-control" name="special_ip_list"  value=""rows="5" id="special_ip_list"><?php echo $special_ip_list;?></textarea>
</div>
-->
</div>
<br>
<button   class="btn btn-default" name="saveaccessplan" value="Save Details" onclick="save_access_plan(); return false;">Save</button>
<?php if($getuid!='0'){?>
<a href="access_plan_edit.php?uid=<?php echo $getuid;?>&access_type=delete" class="btn btn-default" id="del_accessplan" onclick="return confirm('Do you really want to delete this?')">Delete</a>
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
