<?php

$ebdbname="wifihotspot";
$ebdbuser="mydbadmin";
$ebdbhost="localhost";
$ebdbpass="Geng0yoo";
$appcompanyname="TechnoInfotech";
$appname="TechnoAir";
$appversion="1.0";
$supportdate="31-12-2017";

$mysqldblink = new mysqli($ebdbhost, $ebdbuser, $ebdbpass, $ebdbname);

if($mysqldblink->connect_errno > 0){
    die('Unable to connect to database [' . $mysqldblink->connect_error . ']');
}

$sqlxz="SELECT `type_of_msg` , `msg_in_config` , `msg_data` FROM `config_info` ORDER BY `uid` ASC";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
if($mysqlrow['type_of_msg']=="COMPANY_NAME"){$companyname=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="COMPANY_URL"){$companyurl=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="COMPANY_LOGO_PATH"){$companylogo=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="TERM_MSG"){$termline=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="ENABLED_TITLE"){$enablelinemsg=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="EXPIRE_TITLE"){$expirelinemsg=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="RENEW_MSG"){$renewmsgmsg=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="LOGIN_GLOBAL_MSG"){$globallinemsg=$mysqlrow['msg_data'];}
if($mysqlrow['type_of_msg']=="TODAY_CODE_TIME"){$todaycodemin=$mysqlrow['msg_data'];}
}
$appcompanyname=$companyname;
?>
