<?php
$submoduleid=16;
include_once('common_tools.php');
if($userlogin==1){html_header_to_show();}
?>
<div class="container">
<h4 class="page-header">Add WIFI Modem Info User</h4>
<?php

if($userlogin==1 && $accessokformodule==1)
{
 if(isset($_POST['savewifimodem']))
{
//$modem_ssid=$_POST['modem_ssid'];
$modem_ip=$_POST['modem_ip'];
$sqlxy = "SELECT modem_ip FROM wifi_modem_info  WHERE modem_ip ='$modem_ip'";
//print $sqlxy;
$mysqlresult1 = $mysqldblink->query($sqlxy);
if(mysqli_num_rows($mysqlresult1) >= 1){?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Wifi Modem IP already exist.
    </div>
 
<?php
}


}
$uid=$_POST['uid'];
$modem_location=$_POST['modem_location'];
$modem_ip=$_POST['modem_ip'];
$modem_ssid=$_POST['modem_ssid'];
$modem_active=$_POST['modem_active'];
$savedetails=$_POST['savedetails'];

if($savedetails=='save_wifimodem')
	{
$sqlx="INSERT INTO `wifi_modem_info`(`modem_location`, `modem_ssid`,  `modem_ip`, `modem_active`)  VALUES ('$modem_location', '$modem_ssid', '$modem_ip', '$modem_active');";
#print "$sqlx";
$mysqlresult = $mysqldblink->query($sqlx);
//echo $sqlx;
if($mysqlresult){?>
   <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Wifi Modem Info Created Successfully.
    </div>
<?php
} 
} 

?>
<?php

 ?>       
 <form action=""  method="post" name="newadd" id="newadd">
 <input type="hidden" name="savedetails" value="save_wifimodem" >
<div class="row">
<div class="col-md-3">Modem Location:<input type="text"  class="form-control" name="modem_location" value="<?php echo $modem_location;?>" required/></div>
<div class="col-md-3">SSID :<input type="text"  class="form-control" name="modem_ssid" value="<?php echo $modem_ssid;?>" required/></div>
<div class="col-md-3">Modem IP :<input type="text"  class="form-control" name="modem_ip" value="<?php echo $modem_ip;?>" required/></div>
<div class="col-md-3">Installation :<select class="form-control" name="modem_active">
<option value="1" <?php echo $active;?> >Installed </option>
<option value="0" selected <?php echo $inactive;?> >NOT Installed</option>
</select>
</div>
</div>
<br>
<button   class="btn btn-default" name="savewifimodem" value="Save Details" onclick="save_wifi_modem_user(); return false;">Create Wifi Modem User</button>
</form>        
</div>
<?php
}
html_footer_to_show();
?>
