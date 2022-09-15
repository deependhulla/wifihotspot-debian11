<?php
$submoduleid=20;
include_once('common_tools.php');
$getuid= $_REQUEST['uid'];
$type_restore=$_REQUEST['type_restore'];
$type_restore_terms=$_REQUEST['type_restore_terms'];

$mylogo="http://infodev.technoinfotech.com/wifiadmin/images/";
$save_message= $_POST['save_message'];
$msg_type= $_POST['msg_type'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<div class="container">
<h4 class="page-header">System Message |  &nbsp; UID:<?php echo $getuid;?></h4>

<!--Start Restore Button for terms & condition Message text area -->
<script>
function confirmrestore(){
var y=confirm("Are you sure you want to Restore Default Terms & Condition");
if(y==true){
window.location="system_message_edit.php?uid=<?php echo $getuid;?>&type_restore=restore";
}}
</script>

<?php
$def_restore = file_get_contents("term.txt");
$def_restore = trim($def_restore);

if($type_restore=='restore'){
$sqlrest = "UPDATE config_info SET msg_data='$def_restore' WHERE uid= $getuid LIMIT 1";
$mysqlrest = $mysqldblink->query($sqlrest);
}
?>
<!--End Restore Button for terms & condition Message text area -->

<!--Start Restore Button for terms msg -->
<script>
function confirmterms(){
var y=confirm("Are you sure you want to Restore Terms & Condition Message");
if(y==true){
window.location="system_message_edit.php?uid=<?php echo $getuid;?>&type_restore_terms=terms";
}}
</script>

<?php
$my_terms='I agree to <a href=\"../wifilogin/terms.php\" target="_blank">Terms & Condition</a> of company and would use for good purpose.';
$my_terms= trim($my_terms);

if($type_restore_terms=='terms'){
$sqlrest1 = "UPDATE config_info SET msg_data='$my_terms' WHERE uid= $getuid LIMIT 1";
$mysqlrest1 = $mysqldblink->query($sqlrest1);
}
?>
<!--End Restore Button for terms msg -->

<?php
$_POST['msg_data']=str_replace("'","\'",$_POST['msg_data']);
$_POST['msg_data']=str_replace('"','\"',$_POST['msg_data']);

if($save_message=='savedetails'){
$okupdate=1;
if($getuid=="22")
{
#print "verifiny with Online Server @ TechnoInfotech.";
$cmdx="/usr/local/webadmin/wifidirect/get-system-key";
$lkey=`$cmdx`;
$lkey=str_replace("\n","",$lkey);
$lkey=str_replace("\r","",$lkey);
$lkey=str_replace("\t","",$lkey);
$lkey=str_replace("\0","",$lkey);
$lkey=str_replace(" ","",$lkey);
$urlx="https://mail.technomail.in/technoairlic/keycheck.php?key=".$lkey."&lkey=".$_POST['msg_data'];
#print "$urlx";
$licd=array();
$licd=json_decode(file_get_contents($urlx),true);
#print_r($licd);
if($licd['success']=="1"){file_put_contents('/var/www/html/wifiadmin/lic.php', $licd['display']);}
#print "-------------".$licd['display'];
if($licd['success']=="0"){$okupdate=0;}

}
$operror=1;
if($okupdate==1)
{
$sqlb="UPDATE `config_info` SET `msg_data`= '". $_POST['msg_data'] ."'  where `uid` =' ".$getuid."' " ;
$mysqlresultxx=$mysqldblink->query($sqlb);
if($mysqlresultxx){$operror=0;}
}
if($operror==0){?>
<div class="alert alert-success">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Message Updated  Successfully.
    </div>
<?php
//header("Location: system_message.php");
}else{?>
 <div class="alert alert-danger">
        <a href="#" "close" data-dismiss="alert">&times;</a>
<?php 
if($getuid=="22"){ print "<strong>Failed!</strong> ".$licd['display'];} 

if($getuid!="22"){ print "<strong>Failed!</strong> Your Message Cannot be Updated Successfully."; }

?>
    </div>

<?php
} 

////////////// Logo start here //////////////////////////
if (!empty($_FILES["uploadedimage"]["name"])) {
  $stype = $_FILES["uploadedimage"]["type"];
  $pname = $_FILES["uploadedimage"]["name"];
  $tname = $_FILES["uploadedimage"]["tmp_name"];
  $fsize = $_FILES["uploadedimage"]["size"];
 
	$ext = pathinfo($pname, PATHINFO_EXTENSION);
	$allowed = array('jpg','png','gif');
	if(!in_array( $ext, $allowed ))
 	{
	echo 'Image Must be png';
	}
	else
	{
//$uploads_dir = "./../wifiadmin/images/".rand().$pname;
$uploads_dir = "/var/www/html/wifilogin/images/".rand().$pname;

$cleanName = substr_replace($uploads_dir, "", 0, 24);
echo $cleanName;
if(move_uploaded_file($tname, $uploads_dir)){
		$sqly="UPDATE `config_info` SET `msg_data` = '$cleanName' WHERE `config_info`.`uid` ='".$getuid."'";
                $mysqldblink->query($sqly);
}}
}	         
////////////// Logo End here //////////////////////////
}

$sqlx="SELECT `uid`,  `create_type`, `type_of_msg`, `msg_in_config`, `msg_data` FROM `config_info` WHERE `uid` = ".$getuid ;
$mysqlresultx = $mysqldblink->query($sqlx);
while($mysqlrow = $mysqlresultx->fetch_array()){
//print_r($mysqlrow);
$getuid=$mysqlrow['uid'];
$msg_in_config=$mysqlrow['msg_in_config'];
$msg_data=$mysqlrow['msg_data'];
$mylogo=$mysqlrow['msg_data'];

}
?>
<form action=""  method="post" name="myform" enctype="multipart/form-data" id="myform" onSubmit="return confirmForm(this);">
<input type="hidden" name="save_message" value="savedetails">

<?php
////////////////////
if($getuid=="22")
{
?>
<div class="panel panel-success">
<div class="panel-heading">
<?php
$cmdx="/usr/share/webmin/wifidirect/get-system-key";
$lkey=`$cmdx`;
print "Your Server Key : <strong>".$lkey."</strong><br>Please send this key as email to info@technoinfotech.com, <br>with your company details and contact number to get Support Licence Key.";
?>
</div>
</div>
<?php
}

//////////////////////
?>
<div class="row">
<div class="col-md-6">
Message Type : <?php echo $msg_in_config;?>
</div>
</div>

<br>
<br>
<div class="row">
<div class="col-md-6">
<!--Message: -->
<?php
#$msg_data=str_replace('"','\"',$msg_data);
$msg_data=htmlentities($msg_data);
if($getuid!=3 && $getuid!=4 && $getuid!=11 && $getuid!=16 && $getuid!=14 && $getuid!=15 && $getuid!=19 && $getuid!=20){?>

<input type="text" class="form-control" name="msg_data" value="<?php echo $msg_data; ?>" >
<?php
}

if($getuid == 14){
?>
<input type="number"  class="form-control" name="msg_data" value="<?php echo $msg_data;?>" pattern="[0-9]" min="1" >
<?php
}

if($getuid == 15){
?>
<input type="number"  class="form-control" name="msg_data" value="<?php echo $msg_data;?>" pattern="[0-9]" min="1" >
<?php
}



if($getuid==3){
?>
 <input type="hidden" class="form-control" name="msg_data" value="<?php echo $msg_data;?>" >
Current Logo : <img src="../wifilogin/<?php echo $mylogo;?>" align=center height=100 width=100>
<hr>Upload New Logo <br>(Prefered transparent background png file with max size of W-300xH-150) : <input type="file" name="uploadedimage" id="uploadedimage">
<?php } ?>

<?php
if($getuid==4)
{?>
<input type="text" class="form-control" name="msg_data" value="<?php echo $msg_data; ?>" >
<br/><input type="button"  name="terms" value="Restore terms" onClick="confirmterms(); return false;" class="btn btn-default">
<?php
}?>

<?php
if($getuid==11){
?>
<select class="form-control" name="msg_data">
<option value="0" <?php if($msg_data== '0') echo ' selected="selected"'?> >Basic SMS Verification </option>
<option value="1" <?php if($msg_data== '1') echo ' selected="selected"'?> >Package SMS Verification </option>
<option value="2" <?php if($msg_data== '2') echo ' selected="selected"'?> >Package Direct Verification </option>
</select>

<?php
}
if($getuid==16){
?>
<select class="form-control" name="msg_data">
<option value="Direct as Router when behind Firewall/Proxy/Router" <?php if($msg_data== 'Direct as Router when behind Firewall/Proxy/Router') echo ' selected="selected"'?> >Direct as Router, when behind Firewall/Proxy/Router </option>
<option value="Direct ISP Terminated" <?php if($msg_data== 'Direct ISP Terminated') echo ' selected="selected"'?> >Direct ISP Terminated </option>
</select>

<?php
}
if($getuid==19){
?>
<textarea class="form-control" rows="20" name="msg_data" ><?php echo $msg_data; ?></textarea>
<br/><input type="button"  name="restore" value="Restore default" onClick="confirmrestore(); return false;" class="btn btn-default">
<?php
}
?>

<?php
if($getuid==20){
?>
<select class="form-control" name="msg_data">
<option value="0" <?php if($msg_data== '0') echo ' selected="selected"'?> >Hidden </option>
<option value="1" <?php if($msg_data== '1') echo ' selected="selected"'?> >Plain Text Check </option>
<option value="2" <?php if($msg_data== '2') echo ' selected="selected"'?> >Check Mob No. </option>
</select>
<?php
}
?>


</div>
</div>

<br>
<button  name="savemsg" value="Save Message" class="btn btn-default" onclick="save_msg();return false;"><span>Save</span></button>
<!--<input type="button"  name="delmsg" value="Delete" onClick="confirmdel_msg(); return false;" class="btn btn-default">-->
</form>

<?php
}
html_footer_to_show();
?>
