<?
$submoduleid=20;
include_once('common_tools.php');
$getuid= $_REQUEST['uid'];
$save_message= $_POST['save_message'];
$msg_type= $_POST['msg_type'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<div class="container">
<h4 class="page-header">System Message |  &nbsp; UID:<?=$getuid;?></h4>
<?

if($save_message=='savedetails'){
$sqlb="UPDATE `config_info` SET `msg_data`= '". $_POST['msg_data'] ."'  where `uid` =' ".$getuid."' " ;
$mysqlresultxx=$mysqldblink->query($sqlb);
if($mysqlresultxx){?>
<div class="alert alert-success">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your Message Updated  Successfully.
    </div>
<?
//header("Location: system_message.php");
}else{?>
 <div class="alert alert-danger">
        <a href="#" "close" data-dismiss="alert">&times;</a>
        <strong>Failed!</strong> Your Message Cannot be Updated Successfully.
    </div>

<?
}
}

$sqlx="SELECT `uid`,  `create_type`, `type_of_msg`, `msg_in_config`, `msg_data` FROM `config_info` WHERE `uid` = ".$getuid ;
$mysqlresultx = $mysqldblink->query($sqlx);
while($mysqlrow = $mysqlresultx->fetch_array()){
//print_r($mysqlrow);
$getuid=$mysqlrow['uid'];
$msg_in_config=$mysqlrow['msg_in_config'];
$msg_data=$mysqlrow['msg_data'];
}

?>
<form action=""  method="post" name="myform" id="myform" onSubmit="return confirmForm(this);">
<input type="hidden" name="save_message" value="savedetails">

<div class="row">
<div class="col-md-6">
Message Type : <?=$msg_in_config;?>
</div>
<br>
<br>
<div class="col-md-6">
Message: <input type="text" class="form-control" name="msg_data" value="<?=$msg_data?>" >
</div>
</div>
<br>
<br>
<button  name="savemsg" value="Save Message" class="btn btn-default" onclick="save_msg();return false;"><span>Save</span></button>
<!--<input type="button"  name="delmsg" value="Delete" onClick="confirmdel_msg(); return false;" class="btn btn-default">-->
</form>
</div>

<?
}
html_footer_to_show();
?>
