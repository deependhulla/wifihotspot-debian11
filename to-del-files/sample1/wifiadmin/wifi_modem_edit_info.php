<?php
$submoduleid=16;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
$savedetails=$_POST['savedetails'];
$type_wifi=$_REQUEST['type_wifi'];
$getu=$_REQUEST['getu'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<div class="container">
<h4 class="page-header">Update Wifi Modem | UId : <?php echo $getuid;?></h4>

<?php
if($type_wifi=='del'){
$sqldel = "DELETE FROM `wifi_modem_info` WHERE uid= $getu" ;
$mysqldel = $mysqldblink->query($sqldel);
header("Location: wifi_modem_info.php");
}


if(isset($_POST['savewifimodem']))
{
$modem_ip=$_POST['modem_ip'];
$sqlxy = "SELECT modem_ip FROM wifi_modem_info  WHERE modem_ip ='$modem_ip'";
//print $sqlxy;
$mysqlresult1 = $mysqldblink->query($sqlxy);
if(mysqli_num_rows($mysqlresult1)>= 1){?>
<div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Wifi Modem ip already exist.
    </div>

<?php
}


}


if($savedetails=='save_wifimodem') 
{
$sqlx="UPDATE `wifi_modem_info` SET ";
$sqlx=$sqlx."`modem_ssid`= '". csx($_POST['modem_ssid']) ."', " ;
$sqlx=$sqlx."`modem_location`= '". csx($_POST['modem_location']) ."', " ;
$sqlx=$sqlx."`modem_ip`= '". csx($_POST['modem_ip']) ."', " ;
$sqlx=$sqlx."`modem_active`= '". csx($_POST['modem_active']) ."' " ;
$sqlx=$sqlx." where `uid` =' ".$getuid."' " ;
$mysqlresultx=$mysqldblink->query($sqlx);
if($mysqlresultx){
header("Location: wifi_modem_info.php");
} 
}


$sqlxz="SELECT * FROM `wifi_modem_info` Where `uid`= $getuid";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_array()){
$getuid=$mysqlrow['uid'];
$modem_location=$mysqlrow['modem_location'];
$modem_ip=$mysqlrow['modem_ip'];
$modem_ssid=$mysqlrow['modem_ssid'];
$modem_active=$mysqlrow['modem_active'];
if($mysqlrow['modem_active']=="1"){$active="selected";}
if($mysqlrow['modem_active']=="0"){$inactive="selected";}

}
?>

<form action=""  method="post" name="newadd" id="newadd" onSubmit="return confirmForm(this);">
<input type="hidden" name="savedetails" value="save_wifimodem" >
<div class="row">
<div class="col-md-3">Modem Location:<input type="text"  class="form-control" name="modem_location" value="<?php echo $modem_location;?>" required/></div>
<div class="col-md-3">SSID :<input type="text"  class="form-control" name="modem_ssid" value="<?php echo $modem_ssid;?>" required/></div>
<div class="col-md-3">Modem IP :<input type="text"  class="form-control" name="modem_ip" value="<?php echo $modem_ip;?>" required/></div>
<div class="col-md-3">Installation :<select class="form-control" name="modem_active">
<option value="1" <?php echo $active;?> >Installed</option>
<option value="0"  <?php echo $inactive;?> >NOT Installed</option>
</select>
</div>
</div>
<br>
<button   class="btn btn-default" name="savewifimodem" value="Save Details" onclick="save_wifi_modem_user(); return false;">Save</button>
<input   type="button" name="delwifimodem" value="Delete" onClick="confirmdel(); return false;" class="btn btn-default">
</form>        
</div>

<script>
function confirmdel(){
//var x=document.myform.modem_ssid.value;
var y=confirm("Are you sure you want to delete?");
if(y==true){
window.location="wifi_modem_edit_info.php?getu=<?php echo $getuid;?>&type_wifi=del";
}

}
</script>

<?php
}
html_footer_to_show();
?>
