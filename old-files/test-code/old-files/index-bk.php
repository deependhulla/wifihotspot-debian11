<?php
//include 'dbconfig.php';
include_once('dbconfig.php');
include_once('checkusermb.php');
$activembplan=1;

$todaycodex="y";

$companyname="TechnoInfotech";
$companylogo="images/company-logo.png";
$companyurl="http://www.technoinfotech.com/";
$termline="<font size=1>I agree to Terms & Condition of company and would use for good purposex.</font>";
$renewmsgmsg=" Pls Contact IT Team";
$expirelinemsg="Your wifi Internet Package has expired";
$globallinemsg="Welcome to TechnoInfotech Wifi Internet Access Package.";
$enablelinemsg="Your wifi internet package has been activated.";
$todaycodemin=0;

$sqlxz="SELECT `code_date` , `today_code` FROM `today_code_info` WHERE `code_date` = CURDATE() ";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
$todaycodex=$mysqlrow['today_code'];
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

$internetok=0;
$myfun=$_POST['myfun'];
$gotuidx=$_POST['gotuidx'];
$again_sent_code=$_POST['again_sent_code'];
$again_reg=$_POST['again_reg'];
#print "--> $again_reg ";
if($myfun==""){$myfun="newreg";}

$ipAddress=$_SERVER['REMOTE_ADDR'];$macAddr=false;
$arp=`arp -a $ipAddress`;$lines=explode("\n", $arp);
foreach($lines as $line){
$cols=preg_split('/\s+/', trim($line));$cols[1]=str_replace("(","",$cols[1]);
$cols[1]=str_replace(")","",$cols[1]); if ($cols[1]==$ipAddress){$macAddr=$cols[3]; }
}
if($macAddr =="")
{
## FACKMAC#
$macAddr="B8:B4:2E:FE:85:94";
}
$macAddr=strtoupper($macAddr);
//print "IP : $ipAddress MAC : $macAddr";

$gotuidx=0;
$gotreg=0;
$gotmobile="";
$gotmobblock=0;
$gotmacblock=0;
$gotplan=0;
function checkmacuid()
{
global $mysqldblink;
global $gotuidx;
global $macAddr;
global $myifun;
global $gotreg;
global $gotmobile;
global $gotplan;
global $gotregdate;
global $gotmacblock;
global $gotmobblock;
$sqlxz = "SELECT `uid`,`user_reg_active`,`user_mobile`,`user_mac_blocked`,`user_mobile_blocked`,`user_access_plan`, Date_Format( `user_reg_datetime`, '%Y-%m-%d' ) as regdate   FROM `mac_user_info` where `user_mac_address`='".$macAddr."' order by uid DESC limit 0 ,1";
#print $sqlxz;
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
#print_r($mysqlrow);
$gotuidx=$mysqlrow['uid'];
$gotreg=$mysqlrow['user_reg_active'];
$gotmobile=$mysqlrow['user_mobile'];
$gotregdate=$mysqlrow['regdate'];
$gotmobblock=$mysqlrow['user_mobile_blocked'];
$gotmacblock=$mysqlrow['user_mac_blocked'];
$gotplan=$mysqlrow['user_access_plan'];
}
}

checkmacuid();

##### check for mobile for block before active  -start
$xreg_mob = trim($_POST['reg_mob']);
$csqlxz = "SELECT `uid`,`user_reg_active`,`user_mobile`,`user_mac_blocked`,`user_mobile_blocked`   FROM `mac_user_info` where `user_mobile`='".$xreg_mob."' and `user_mobile_blocked` =1  limit 0 ,1";
#print "\n $csqlxz \n";
$cmysqlresult = $mysqldblink->query($csqlxz);
while($cmysqlrow = $cmysqlresult->fetch_assoc()){
$gotmobblock=1;
$myfun="internetactive";
}
##### check for mobile for block before active  -end


if($gotuidx!=0 && $gotreg==0 && $myfun=="newreg"){$myfun="smscodesend";}
if($gotuidx!=0 && $gotreg==1 && $myfun=="newreg"){$myfun="internetactive";}


if($again_reg=="yes")
{
if($gotuidx!="")
{
$deldvdx="DELETE FROM `mac_user_info` WHERE `mac_user_info`.`uid` = $gotuidx";
$mysqlresult = $mysqldblink->query($deldvdx);

#print "dvd --> $gotuidx  $deldvdx";
}
$myfun="newreg";
}



#print "--> $gotuidx --> $gotreg -- $myfun";
?>
<?php 
// code for sms -- start
function getDistinctNr($min, $max) {
  $nrstr = (string) mt_rand($min, $max);     // get random number, converted into string
  $n_nr = strlen($nrstr);           
  $setnr = array();           // to store distinct digits that will form the returned number

  // traverse the characters of $nrstr to add in $setnr only its distinct digits
  // if number already in $setnr, traverse 0 to 9 to define another distinct number
  for($i=0; $i<$n_nr; $i++) {
    if(!in_array($nrstr[$i], $setnr)) $setnr[] = $nrstr[$i];
    else {
      for($i2=0; $i2<10; $i2++) {
        if(!in_array($i2, $setnr)) {
          $setnr[] = $i2;
          break;
        }
      }
    }
  }

  return implode('', $setnr);
}
// code for SMS  -- end


///// sendsms now --start
$smsmsg="";
$smsenddone=0;
function sendsmsnow()
{
global $smsenddone;
global $gotuidx;
global $smsmsg;
global $gotmobile;
global $mysqldblink;
$sendnowx=1;
$specialcodeactive=0;
$smscodex="";
$sqlx="SELECT `specialcodeactive`,`specialcode` FROM `mac_code_info` WHERE `live_date` = CURDATE() AND `userid` = ".$gotuidx."  AND `specialcodeactive` < 3";
$xmysqlresult = $mysqldblink->query($sqlx);
while($mysqlrow = $xmysqlresult->fetch_assoc()){
$smscodex=$mysqlrow['specialcode'];
$specialcodeactive=$mysqlrow['specialcodeactive'] + 1;
}
#print "sms send to you --> $gotuidx -- $gotmobile --> $smscodex -->  $sqlx";
if($smscodex!="")
{
$smsenddone=1;
$smstext="Access Code is : ".$smscodex;
$smstextmsg=urlencode($smstext);
$urlx="http://technoworld.in/cgi-bin/gsmmodem/sendviagsm230.cgi?mobileno=91".$gotmobile."&message=$smstextmsg";
$urlxdata=file_get_contents($urlx);
#print "\n $urlx --> $urlxdata \n";
$sqlx="UPDATE `mac_code_info` SET `specialcodeactive` = ".$specialcodeactive." WHERE  `live_date` = CURDATE() AND `userid` = ".$gotuidx." ";
$xmysqlresult = $mysqldblink->query($sqlx);
#print " \n <hr>$sqlx <hr>";
}
#$smsmsg="We have send you a smscode";
}
///// sendsms now --end

if($myfun=="newregsave")
{
if(isset($_POST['reg_submit']))
{
$reg_fname =trim($_POST['reg_fname']);
$reg_email = trim($_POST['reg_email']);
$reg_mob = trim($_POST['reg_mob']);
$reg_agree = trim($_POST['reg_agree']);
$nr = $_POST['nr'];
$gotuidx=$_POST['gotuidx'];

// Full Name
if(empty($reg_fname))
 {
$error_fname="Please enter your full name.";
$myfun="newreg";
}
elseif (eregi('^[A-Za-z0-9 ]{3,80}$',$reg_fname))
{
$valid_fname=$reg_fname;
}
else
{
$error_fname='Enter valid Name, min 3 character.';
$myfun="newreg";
}

//check if the mob number field is numeric
if(is_numeric($reg_mob) == false )
{
$error_mob= "Please enter Mobile No.";
$myfun="newreg";
}
elseif (strlen($reg_mob)>10 || strlen($reg_mob)<10)
{
$error_mob= "Number should be 10 digits.";
$myfun="newreg";
//$valid_mob=$mob;
}
else
{
$valid_mob= $reg_mob;
}

// Email 
 if (eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $reg_email))
{
$valid_emails=$reg_email;
}
else
{
$error_emails='Enter valid email.';
$myfun="newreg";
}

$useremailbreak=array();
$useremailbreak=explode("@",$reg_email);
//print "DOMain :".$useremailbreak[1];
$getdomainipx=gethostbyname($useremailbreak[1]);
//print "-->".$getdomainipx."<--";
$domainok=1;
if($getdomainipx == $useremailbreak[1])
{
$domainok=0;
//}

//print "Domain OK :".$domainok." \n";
$error_email="Enter valid email address";
$myfun="newreg";
}else {
$valid_email=$reg_email;
}


if(empty($reg_agree)) {
   $error_agree= "Please check the box";
$myfun="newreg";
}
else
{
$valid_agree= $reg_agree;
}

$nr = getDistinctNr(1000, 9999);

//print "--> $myfun";
if($myfun=="newregsave")
{

$regx="INSERT INTO `mac_user_info`(`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `user_mac_address`, `user_full_name`, `user_mobile`, `user_email`, `user_membership_no`, `user_extra_office_info`, `user_access_plan`, `user_device_type`, `user_reg_browser_full_info`, `user_reg_browser`, `user_reg_device`, `user_reg_datetime`, `user_reg_active`, `user_activaton_datetime`, `user_mac_blocked`, `user_mobile_blocked`, `user_block_reason`, `user_block_datetime`, `user_internal_comments`, `user_ip_address`) VALUES ('','','',NOW(),'','$macAddr','$reg_fname','$reg_mob','$reg_email','','','0','','','','',NOW(),'','','','','','','','$ipAddress')";
//print $regx;
$mysqlresulti = $mysqldblink->query($regx);
$gotuidx=mysqli_insert_id($mysqldblink);

$regy="INSERT INTO `mac_code_info`(`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `live_date`, `userid`, `specialcode`, `specialcodeactive`) VALUES ('','','',NOW(),'',NOW(),'$gotuidx','$nr','')";
//print $regy;
$mysqlregy = $mysqldblink->query($regy);
checkmacuid();
sendsmsnow();
$myfun="smscodesend";

}
}
// newregsave over
}

// resend code start 
if($again_sent_code!="")
{
$myfun="smscodesend";
sendsmsnow();
if($smsenddone==1){$success_sms_code="SMS has been send again to your mobile. it would arrive in a minute.";}
if($smsenddone==0){$error_sms_code="SMS has been send again to your mobile. it would arrive in a minute.";}

#print "sended again";
}
// resend code end 


/// sms code check start
if($myfun=="checksmscode")
{
#print "zxxxxxxx";
$sms_reg_code =$_POST['sms_reg_code'];

$sms_reg_code=str_replace(" ","",$sms_reg_code);
$sms_reg_code=str_replace(";","",$sms_reg_code);
$sms_reg_code=str_replace("-","",$sms_reg_code);
$sms_reg_code=str_replace("|","",$sms_reg_code);
$sms_reg_code=str_replace("'","",$sms_reg_code);
$sms_reg_code=str_replace("\"","",$sms_reg_code);

$sqlxy = "SELECT `specialcode` FROM mac_code_info  WHERE  `live_date` = CURDATE() AND  `specialcode` ='".$sms_reg_code."' and `userid` = ".$gotuidx;
#print " -- > $sqlxy";
$mysqlresults = $mysqldblink->query($sqlxy);
if(mysqli_num_rows($mysqlresults) >= 1){
$internetok=1;
$myfun="internetactive";

## do update Query
$sqlx="UPDATE `mac_user_info` SET `user_reg_active` = '1', `user_activaton_datetime` = NOW() WHERE `uid` = $gotuidx";
$mysqlresultu =$mysqldblink->query($sqlx);
### update Default plan here

$gotmin=0;
$sqlz="SELECT `uid`, `create_by_user`, `create_on_date`, `create_type`, `reset_daily`, `user_access_plan_name`, `user_ip_notallowed_list`, `validity_period_in_mins`, `traffic_limit_in_mb`, `basic_upload_max_speed_kbps`, `basic_download_max_speed_kbps`, `special_ip_list`, `access_plan_active`, `internal_notes` FROM `wifi_access_plan` WHERE `uid` = 0 ";
#print "<hr>$sqlz<hr>";
$zmysqlresult = $mysqldblink->query($sqlz);
while($zmysqlrow = $zmysqlresult->fetch_assoc()){
$gotmin=$zmysqlrow['validity_period_in_mins'];
}
$sqlinx="INSERT INTO `wifi_live_plans` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `mac_uid`, `plan_uid`, `start_time`, `end_time`, `access_plan_live`) VALUES (NULL, NULL, '', NOW(), '', '".$gotuidx."', '0',  NOW(), DATE_ADD(NOW(), INTERVAL ".$gotmin." MINUTE), '1');";
$zmysqlresult = $mysqldblink->query($sqlinx);
#print "<hr>$sqlinx<hr>";


/// SMS CODE MATCHED ...and default applied too
}
else {
$myfun="smscodesend";
$error_sms_code="SMS Code Not matched. Please Enter the Proper Code";
}

//sendsmsnow();
}
/// sms code check end


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>WifiHotSpot Reg. <?=$companyname?></title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sign.css" rel="stylesheet">
         <style>
            .reg_error {color: #FF0000;}
            .reg_yes {color: green;}
         </style> 
  </head>

  <body>
    <div class="container">
<div align=center>    <img src="<?=$companylogo?>" align=center></div>
<?php
if($myfun=="internetactive")
{
?>
<center>Your Device Unique <br>ID : <b><font color=green><?=$gotuidx?></font></b></center>
<?
$timeok=0;
//print "$gotmobblock --> $gotmacblock --> $gotplan";


if($_POST['myfuntoday']!="")
{
$gottoday=0;
if($todaycodex == $_POST['todaycode']){$gottoday=1;}
#print "check today coe --> $todaycodex --> $gottoday";
if($gottoday==1)
{
//$sqlinx="INSERT INTO `wifi_live_plans` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `mac_uid`, `plan_uid`, `start_time`, `end_time`, `access_plan_live`) VALUES (NULL, NULL, '', NOW(), '', '".$gotuidx."', '-1',  NOW(), DATE_ADD(NOW(), INTERVAL ".$todaycodemin." MINUTE), '1');";


$sqlinx="INSERT INTO `wifi_live_plans` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `mac_uid`, `plan_uid`, `start_time`, `end_time`, `access_plan_live`) VALUES (NULL, NULL, '', NOW(), '', '".$gotuidx."', '-1',  NOW(), '".date("Y-m-d")." 23:59:59', '1');";
#print "<hr>$sqlinx<hr>";
$zmysqlresult = $mysqldblink->query($sqlinx);

}
}


////// work for plan check start
$recthere=0;
$sqlx1="SELECT `uid`, `mac_uid`, `plan_uid`,  `start_time`, `end_time`, `access_plan_live` FROM `wifi_live_plans` WHERE `mac_uid` = ".$gotuidx."  and `end_time`>NOW() and `uid` in (SELECT `uid` FROM ( ( SELECT `uid`  FROM `wifi_live_plans`  WHERE `mac_uid` = ".$gotuidx." ORDER BY `uid` DESC LIMIT 0,1) z ) )";
#print "$sqlx1 <hr>";
$expiretime="";
$tmysqlresult = $mysqldblink->query($sqlx1);
while($tmysqlrow = $tmysqlresult->fetch_assoc())
{
## planthere already
$recthere=2;

}

$sqlx="SELECT `uid` FROM `wifi_live_plans` WHERE `mac_uid` = ".$gotuidx." and Date_Format( create_on_date, '%Y-%m-%d' ) = CURDATE( ) ORDER BY `uid` DESC LIMIT 0,1";
#print "<hr>$sqlx<hr>";

$tmysqlresultu = $mysqldblink->query($sqlx);
while($tmysqlrow = $tmysqlresultu->fetch_assoc())
{
$recthere=1;
}

### disabled by making to 3 instead to 0
if($recthere==0 && $gotplan!=0 )
{
$gotmin=0;
$sqlz="SELECT `uid`, `create_by_user`, `create_on_date`, `create_type`, `reset_daily`, `user_access_plan_name`, `user_ip_notallowed_list`, `validity_period_in_mins`, `traffic_limit_in_mb`, `basic_upload_max_speed_kbps`, `basic_download_max_speed_kbps`, `special_ip_list`, `access_plan_active`, `internal_notes` FROM `wifi_access_plan` WHERE `uid` = ".$gotplan." ";
#print "<hr>$sqlz<hr>";
$zmysqlresult = $mysqldblink->query($sqlz);
while($zmysqlrow = $zmysqlresult->fetch_assoc()){
$gotmin=$zmysqlrow['validity_period_in_mins'];
}
$sqlinx="INSERT INTO `wifi_live_plans` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `mac_uid`, `plan_uid`, `start_time`, `end_time`, `access_plan_live`) VALUES (NULL, NULL, '', NOW(), '', '".$gotuidx."', '".$gotplan."',  NOW(), DATE_ADD(NOW(), INTERVAL ".$gotmin." MINUTE), '1');";
$zmysqlresult = $mysqldblink->query($sqlinx);
#print "<hr>$sqlinx<hr>";

}

$sqlx1="SELECT `uid`, `mac_uid`, `plan_uid`,  Date_Format( create_on_date, '%Y-%m-%d' ) AS main_date , `start_time`, `end_time`, `access_plan_live` FROM `wifi_live_plans` WHERE `mac_uid` = ".$gotuidx."  and `end_time`>NOW() and `uid` in (SELECT `uid` FROM ( ( SELECT `uid`  FROM `wifi_live_plans`  WHERE `mac_uid` = ".$gotuidx." ORDER BY `uid` DESC LIMIT 0,1) z ) )";
#print "$sqlx1 <hr>";



## enable all time for plan ZERO
#$timeok=1;
#if($gotplan==0){$timeok=1;}
$gotrcb=0;
$lastplan=0;
$sqlx1="SELECT `uid`, `mac_uid`, `plan_uid`,  `start_time`, `end_time`, `access_plan_live` FROM `wifi_live_plans` WHERE `mac_uid` = ".$gotuidx."  and `end_time`>NOW() and `uid` in (SELECT `uid` FROM ( ( SELECT `uid`  FROM `wifi_live_plans`  WHERE `mac_uid` = ".$gotuidx." ORDER BY `uid` DESC LIMIT 0,1) z ) )";
#print "$sqlx1 <hr>";
$expiretime="";
$tmysqlresult = $mysqldblink->query($sqlx1);
while($tmysqlrow = $tmysqlresult->fetch_assoc())
{
$lastplan=$tmysqlrow['plan_uid'];
$expiretime=$tmysqlrow['end_time'];
$timeok=1;
$gotrcb=1;
}
#print "Expires on $expiretime";
#print "--> GOTRC --> $gotrcb";

////// work for plan check over

#print "if($gotmobblock==0 && $gotmacblock==0 && $timeok==1)";
$dxxx=workmb();
if($dxxx==0){$timeok=0;}
if($dxxx==2){$timeok=0;}

##### check for mobile for block before active  -start
$csqlxz = "SELECT `uid`,`user_reg_active`,`user_mobile`,`user_mac_blocked`,`user_mobile_blocked`   FROM `mac_user_info` where `user_mobile`='".$gotmobile."' and `user_mobile_blocked` =1  limit 0 ,1";
#print "\n $csqlxz \n";
$cmysqlresult = $mysqldblink->query($csqlxz);
while($cmysqlrow = $cmysqlresult->fetch_assoc()){
$gotmobblock=1;
}
##### check for mobile for block before active  -end


if($gotmobblock==0 && $gotmacblock==0 && $timeok==1)
{

$cmdx="/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' \"https://127.0.0.1:8383/wifidirect/index.cgi?macx=".$macAddr."&macipx=".$ipAddress."&activenow=1&\"";
$cmdxs=`$cmdx`;
#print "<hr> $cmdx<hr>";

print "<center><h3 align=center>".$enablelinemsg."</h3>";
if($gottoday==1)
{
print " Your's Wifi's Today-Access-Code was updated successful.<br>";
}
print "Expires on $expiretime</center><br>";
print "<center>".$globallinemsg."</center>";

#print "<center>Current Time  ".date("Y-m-d")."</center><br>";
if($todaycodex!="" && $gottoday==0  && $lastplan!=-1 && $gotplan==0)
{
print $opscodeerror;
?>
<form class="form-signin" method="POST" action="" role="formform">
 <h4 class="form-signin-heading" align="center">Enter Wifi's Today-Access-Code</h4>
<input type=hidden name="myfuntoday" value="todaycodecheck">
<input type="text" name="todaycode" class="form-control" placeholder="Today-Access-Code" value="" autofocus>
<br> <button class="btn btn-lg btn-primary btn-block" type="submit" name="sms_code_submit">Activate Today-Access-Code</button>
</form>
<?
}
?>
<centeR>You can now open <br><a href="<?=$companyurl?>"><?=$companyurl?></a><br>
or <br><a href="http://news.google.co.in/">http://news.google.co.in/</a>
<?
}

if($gotmobblock==1 && $gotmacblock==0){print "<h3 align=center>Your Access is denied.<br>Error Code: 1001 .</h3>";}
if($gotmobblock==0 && $gotmacblock==1 ){print "<h3 align=center>Your Access is denied.<br>Error Code: 2002 .</h3>";}
if($gotmobblock==1 && $gotmacblock==1 ){print "<h3 align=center>Your Access is denied.<br>Error Code: 3003 .</h3>";}

#print "$gotmobblock==0 && $gotmacblock==0 && $timeok==0  && $gotplan==0";
if($gotmobblock==0 && $gotmacblock==0 && $timeok==0  && $gotplan==0)
{
$cmdx="/usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' \"https://127.0.0.1:8383/wifidirect/index.cgi?macx=".$macAddr."&macipx=".$ipAddress."&activenow=0&\"";
$cmdxs=`$cmdx`;
#print "<hr> $cmdx<hr>";
print "<center><h3>".$expirelinemsg."</h3>";
if($dxxx==0){print "Allocated Data usage over.";}
if($dxxx==2){print "Due to Data usage cap.";}
print "<br>".$renewmsgmsg."</center>";
if($todaycodex!="")
{
print $opscodeerror;
?>
<form class="form-signin" method="POST" action="" role="formform">
 <h4 class="form-signin-heading" align="center">Enter Wifi's Today-Access-Code</h4>
<input type=hidden name="myfuntoday" value="todaycodecheck">
<input type="text" name="todaycode" class="form-control" placeholder="Today-Access-Code" value="" autofocus>
<br> <button class="btn btn-lg btn-primary btn-block" type="submit" name="sms_code_submit">Activate Today-Access-Code</button>
</form>
<?
}

}

}
if($myfun=="smscodesend")
{
?>
<form class="form-signin" method="POST" action="" role="formform">
<?=$smsmsg?>
        <h3 class="form-signin-heading" align="center">Please enter SMS Code</h3>
 <input type=hidden name="myfun" value="checksmscode">
<span class="reg_error"><?php echo $error_sms_code; ?></span>
<span class="reg_yes"><?php echo $success_sms_code; ?></span><br/>
<input type="text" name="sms_reg_code" class="form-control" placeholder="Enter Sms code" value="" autofocus>
<br>        <button class="btn btn-lg btn-primary btn-block" type="submit" name="sms_code_submit">Get Wifi Activated</button>
<? if($error_sms_code!=""){ ?>
<br>        <button class="btn btn-lg btn-primary btn-block" type="submit" name="again_sent_code" value="yes"> Send Message again</button>
<? } ?>
<br>        <button class="btn btn-lg btn-primary btn-block" type="submit" name="again_reg" value="yes"> Re-register again</button>
      </form>
<?php
}
?>


<?php

if($myfun=="newreg")
{
// reg form show
?>
      <form class="form-signin" method="POST" action=" <?php echo $_SERVER['PHP_SELF'];?>" role="form">
 <input type=hidden name="myfun" value="newregsave">
        <h4 class="form-signin-headingu" align="center">Registration for wifi internet.</h4>
      <font color=red>*** All fields Compulsory</font>
<input type="text" name="reg_fname" class="form-control" placeholder="Full Name" value="<?php echo $valid_fname; ?>" autofocus>
<span class="reg_error"><?php echo $error_fname; ?></span><br/>
<input type="tel" name="reg_mob" class="form-control" placeholder="10 Digit Mob. No." value="<?php echo $valid_mob; ?>" autofocus>
<span class="reg_error"><?php echo $error_mob;?></span><br/>
<input type="email" name="reg_email" class="form-control" placeholder="Email address" value="<?php echo $valid_email; ?>" autofocus>
<span class="reg_error"><?php echo $error_email;?></span>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="reg_agree" name="reg_agree" autofocus>
 <?=$termline?><br/> <span class="reg_error"><?php echo $error_agree;?></span>
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="reg_submit">Register & get SMS Code</button>
      </form>
<?
}
/// reg form show over
?>

    </div> <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
   <script src="js/bootstrap.min.js"></script>
  </body>
</html>

