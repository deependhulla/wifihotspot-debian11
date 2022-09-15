<?php
include_once('dbconfig.php');

$companylogo="images/company-logo.png";

$sqlxz="SELECT uid,`type_of_msg`, `msg_in_config`, `msg_data` FROM `config_info` WHERE uid=19";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
if($mysqlrow['type_of_msg']=="TERM_MSG"){$termline=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="TERMS_CONDITION_PAGE"){$terms_condition_msg=$mysqlrow['msg_data'];}
}

//$sqlxz="SELECT uid,`type_of_msg`, `msg_in_config`, `msg_data` FROM `config_info` WHERE uid=3";
$sqlxz="SELECT uid,`type_of_msg`, `msg_in_config`, `msg_data` FROM `config_info`";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
if($mysqlrow['type_of_msg']=="COMPANY_NAME"){$companyname=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="COMPANY_LOGO_PATH"){$companylogo=$mysqlrow['msg_data'];}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>WifiHotSpot <?=$companyname?></title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sign.css" rel="stylesheet">
  </head>
<body>
<div class="container">
<div align=center>
<img src="<?=$companylogo?>" align=center height=150 width=300></div>
<center><b><?=$companyname?></b></center>
<center><b><br/>Terms & Conditions</b></center>
<div>
<!--<div align=center>-->
<br/><center><?php echo $terms_condition_msg;?></center>
<!--</div>-->
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
