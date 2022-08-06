<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet" />
</head>
<body onload="window.print()">
<?
$submoduleid=18;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
$rtype=$_REQUEST['rtype'];
$uui=$_REQUEST['uui'];

?>
<div class="container">
<?
if($rtype=="deviceplanhistory"){

$mysqli="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan`,`user_mac_address`,`user_reg_datetime` FROM `mac_user_info` where `uid` = ".$getuid;
$mysqlresulti = $mysqldblink->query($mysqli);
if($mysqlrowi = $mysqlresulti->fetch_array()){
$getuidi=$mysqlrowi['uid'];
$user_full_namei=$mysqlrowi['user_full_name'];
$user_mobilei=$mysqlrowi['user_mobile'];
$user_emaili=$mysqlrowi['user_email'];
$user_access_plani=$mysqlrowi['user_access_plan'];
$user_mac_blockedi=$mysqlrowi['user_mac_blocked'];
$user_mobile_blockedi=$mysqlrowi['user_mobile_blocked'];
$user_reg_activei=$mysqlrowi['user_reg_active'];
$user_mac_addressi=$mysqlrowi['user_mac_address'];
$user_reg_datetimei=$mysqlrowi['user_reg_datetime'];
}
$sqlui="SELECT user_access_plan_name FROM wifi_access_plan where `uid`=$user_access_plani";
$mysqlresultui = $mysqldblink->query($sqlui);
if($mysqlrowi = $mysqlresultui->fetch_array()){
$user_access_plan_namei=$mysqlrowi['user_access_plan_name'];
}


$expiredayi="";
$startdayi="";
$planbyuseri="Default";
$lastplani=$user_access_plan_namei;
$sqlxi="SELECT  a.`verify_type`,a.`verify_info`,a.`additional_notes`,a.`create_by_user` , a.`create_on_date` , a.`mac_uid` , a.`plan_uid` , a.`start_time` , a.`end_time` , a.`access_plan_live`, b.`user_access_plan_name`, b.`traffic_limit_in_mb`, b.`traffic_reset_limit_in_mb`, b.`traffic_reset_period`, a.`plan_price`  FROM `wifi_live_plans` a, `wifi_access_plan` b WHERE a.`plan_uid` =b.`uid` and a.`mac_uid`=".$getuid." and a.`uid`=".$uui." ORDER BY a.uid DESC limit 0,1";
$mysqlresulti = $mysqldblink->query($sqlxi);
if($mysqlrowi = $mysqlresulti->fetch_array()){
$lastplani=$mysqlrowi['user_access_plan_name'];
$startdayi=$mysqlrowi['start_time'];
$expiredayi=$mysqlrowi['end_time'];
$verify_typei=$mysqlrowi['verify_type'];
$verify_infoi=$mysqlrowi['verify_info'];
$createdti=$mysqlrowi['create_on_date'];
$traffic_limit_in_mbi=$mysqlrowi['traffic_limit_in_mb'];
$traffic_reset_limit_in_mbi=$mysqlrowi['traffic_reset_limit_in_mb'];
$traffic_reset_periodi=$mysqlrowi['traffic_reset_period'];
$plan_pricei=$mysqlrowi['plan_price'];
if($mysqlrowi['create_by_user']!="")
{
$planbyuseri=$mysqlrowi['create_by_user'];
}
}

$sqlxz11i="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='COMPANY_NAME'";
$mysqlresultxz11i = $mysqldblink->query($sqlxz11i);
if($mysqlrow11i = $mysqlresultxz11i->fetch_array()){
$comp_namei=$mysqlrow11i['msg_data'];
}

$sqlxz11rri="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='COMPANY_ADDRESS'";
$mysqlresultxz11rri = $mysqldblink->query($sqlxz11rri);
if($mysqlrow11rri = $mysqlresultxz11rri->fetch_array()){
$comp_addri=$mysqlrow11rri['msg_data'];
}

$sqlxz11vvi="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='INVOICE_EXTRA'";
$mysqlresultxz11vvi = $mysqldblink->query($sqlxz11vvi);
if($mysqlrow11vvi = $mysqlresultxz11vvi->fetch_array()){
$invoice_xtrai=$mysqlrow11vvi['msg_data'];
}


?>
 <div class="row pad-top-botm ">
               <h4 style="text-align: center;font-size: 30px;"><? echo  $comp_namei;?></h4>
		<p style="text-align: center;"><b>Wifi Internet Invoice</b></p>
		<p style="text-align: center;"><? echo $comp_addri;?></p>
              </div>
		<p style="text-align: center;font-size: 11px;"><? echo $invoice_xtrai;?></p>
		<p style="float: left;">Device ID: #<? echo $getuid;?></p>
                <p style="float: right;"><? echo date("d-m-y H:i:s");?></p>
<div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 2px;">
                            <tbody>
				<tr>
                                    <th>Name</th>
                                    <td><?=$user_full_namei;?></td>
                                </tr>
				<tr>
                                    <th>Email</th>
                                    <td><?=$user_emaili;?></td>
                                </tr>
				<tr>
                                    <th>Mobile</th>
                                    <td><?=$user_mobilei;?></td>
                                </tr>
				<tr>
                                    <th>Verification Type</th>
                                    <td><?=$verify_typei;?></td>
                                </tr>
				<tr>
                                    <th>Verification ID</th>
                                    <td><?=$verify_infoi;?></td>
                                </tr>
				<tr>
                                    <th>Apply Plan</th>
                                    <td><?=$lastplani;?></td>
                                </tr>
				<tr>
                                    <th>Started</th>
                                    <td><?=$startdayi;?></td>
                                </tr>
				 <tr>
                                    <th>Expires</th>
                                    <td><?=$expiredayi;?></td>
                                </tr>

				 <tr>
                                    <th>Traffic Limit(MB)</th>
                                    <td><?if($traffic_limit_in_mbi == "0"){ echo "Unlimited"; } else {?> <?=$traffic_limit_in_mbi; }?></td>
                                </tr>
				 <tr>
                                    <th>Traffic Reset(MB)</th>
                                    <td><?if($traffic_reset_limit_in_mbi == "0"){ echo "No Cap"; } else {?> <?=$traffic_reset_limit_in_mbi; }?></td>
                                </tr>
				 <tr>
                                    <th>Traffic Limit(Days)</th>
                                    <td><?if($traffic_reset_periodi == "0"){ echo "No Cap"; } else {?> <?=$traffic_reset_periodi; }?></td>
                                </tr>
				<tr>
                                    <th>Plan Applied By</th>
                                    <td><?=$planbyuseri?>  on <?=$createdti?></td>
                                </tr>
				<tr>
                                    <th>Plan Price(INR)</th>
                                    <td><?if($plan_pricei == "0"){ echo "Free"; } else {?> <?=$plan_pricei; }?></td>
                                </tr>
		        </tbody>
                        </table>
		<b>I Acknowledge(signature):</b><div style="width: 200px; height: 50px; border: 1px solid;"></div><br><br>
</div>

<?

}if($rtype=="pactivenormal") {

$mysql="SELECT `uid`, `user_full_name`,`user_mobile`, `user_email`, `user_mac_blocked`, `user_mobile_blocked`,`user_reg_active` ,`user_access_plan`,`user_mac_address`,`user_reg_datetime` FROM `mac_user_info` where `uid` = ".$getuid;
$mysqlresult = $mysqldblink->query($mysql);
if($mysqlrow = $mysqlresult->fetch_array()){
$getuid=$mysqlrow['uid'];
$user_full_name=$mysqlrow['user_full_name'];
$user_mobile=$mysqlrow['user_mobile'];
$user_email=$mysqlrow['user_email'];
$user_access_plan=$mysqlrow['user_access_plan'];
$user_mac_blocked=$mysqlrow['user_mac_blocked'];
$user_mobile_blocked=$mysqlrow['user_mobile_blocked'];
$user_reg_active=$mysqlrow['user_reg_active'];
$user_mac_address=$mysqlrow['user_mac_address'];
$user_reg_datetime=$mysqlrow['user_reg_datetime'];
}
$sqlu="SELECT user_access_plan_name FROM wifi_access_plan where `uid`=$user_access_plan";
$mysqlresultu = $mysqldblink->query($sqlu);
if($mysqlrow = $mysqlresultu->fetch_array()){
$user_access_plan_name=$mysqlrow['user_access_plan_name'];
}


$expireday="";
$startday="";
$planbyuser="Default";
$lastplan=$user_access_plan_name;
$sqlx="SELECT  a.`verify_type`,a.`verify_info`,a.`additional_notes`,a.`create_by_user` , a.`create_on_date` , a.`mac_uid` , a.`plan_uid` , a.`start_time` , a.`end_time` , a.`access_plan_live`, b.`user_access_plan_name`, b.`traffic_limit_in_mb`, b.`traffic_reset_limit_in_mb`, b.`traffic_reset_period`, a.`plan_price`  FROM `wifi_live_plans` a, `wifi_access_plan` b WHERE a.`plan_uid` =b.`uid` and a.`mac_uid`=".$getuid." ORDER BY a.uid DESC limit 0,1";
$mysqlresult = $mysqldblink->query($sqlx);
if($mysqlrow = $mysqlresult->fetch_array()){
$lastplan=$mysqlrow['user_access_plan_name'];
$startday=$mysqlrow['start_time'];
$expireday=$mysqlrow['end_time'];
$verify_type=$mysqlrow['verify_type'];
$verify_info=$mysqlrow['verify_info'];
$createdt=$mysqlrow['create_on_date'];
$traffic_limit_in_mb=$mysqlrow['traffic_limit_in_mb'];
$traffic_reset_limit_in_mb=$mysqlrow['traffic_reset_limit_in_mb'];
$traffic_reset_period=$mysqlrow['traffic_reset_period'];
$plan_price=$mysqlrow['plan_price'];
if($mysqlrow['create_by_user']!="")
{
$planbyuser=$mysqlrow['create_by_user'];
}
}

$sqlxz11="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='COMPANY_NAME'";
$mysqlresultxz11 = $mysqldblink->query($sqlxz11);
if($mysqlrow11 = $mysqlresultxz11->fetch_array()){
$comp_name=$mysqlrow11['msg_data'];
}

$sqlxz11rr="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='COMPANY_ADDRESS'";
$mysqlresultxz11rr = $mysqldblink->query($sqlxz11rr);
if($mysqlrow11rr = $mysqlresultxz11rr->fetch_array()){
$comp_addr=$mysqlrow11rr['msg_data'];
}

$sqlxz11vv="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='INVOICE_EXTRA'";
$mysqlresultxz11vv = $mysqldblink->query($sqlxz11vv);
if($mysqlrow11vv = $mysqlresultxz11vv->fetch_array()){
$invoice_xtra=$mysqlrow11vv['msg_data'];
}


?>

<div class="row pad-top-botm ">
               <h4 style="text-align: center;font-size: 30px;"><? echo  $comp_name;?></h4>
                <p style="text-align: center;"><b>Wifi Internet Invoice</b></p>
                <p style="text-align: center;"><? echo $comp_addr;?></p>
              </div>
                <p style="text-align: center;font-size: 11px;"><? echo $invoice_xtra;?></p>
                <p style="float: left;">Device ID: #<? echo $getuid;?></p>
                <p style="float: right;"><? echo date("d-m-y H:i:s");?></p>
<div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 2px;">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td><?=$user_full_name;?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?=$user_email;?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?=$user_mobile;?></td>
                                </tr>
                                <tr>
                                    <th>Verification Type</th>
                                    <td><?=$verify_type;?></td>
                                </tr>
                                <tr>
                                    <th>Verification ID</th>
                                    <td><?=$verify_info;?></td>
                                </tr>
                                <tr>
                                    <th>Apply Plan</th>
                                    <td><?=$lastplan;?></td>
                                </tr>
                                <tr>
                                    <th>Started</th>
                                    <td><?=$startday;?></td>
                                </tr>
                                 <tr>
                                    <th>Expires</th>
                                    <td><?=$expireday;?></td>
                                </tr>

                                 <tr>
                                    <th>Traffic Limit(MB)</th>
                                    <td><?if($traffic_limit_in_mb == "0"){ echo "Unlimited"; } else {?> <?=$traffic_limit_in_mb; }?></td>
                                </tr>
				 <tr>
                                    <th>Traffic Reset(MB)</th>
                                    <td><?if($traffic_reset_limit_in_mb == "0"){ echo "No Cap"; } else {?> <?=$traffic_reset_limit_in_mb; }?></td>
                                </tr>
                                 <tr>
                                    <th>Traffic Limit(Days)</th>
                                    <td><?if($traffic_reset_period == "0"){ echo "No Cap"; } else {?> <?=$traffic_reset_period; }?></td>
                                </tr>
                                <tr>
                                    <th>Plan Applied By</th>
                                    <td><?=$planbyuser?>  on <?=$createdt?></td>
                                </tr>
                                <tr>
                                    <th>Plan Price(INR)</th>
                                    <td><?if($plan_price == "0"){ echo "Free"; } else {?> <?=$plan_price; }?></td>
                                </tr>
                        </tbody>
                        </table>
                <b>I Acknowledge(signature):</b><div style="width: 200px; height: 50px; border: 1px solid;"></div><br><br>
</div>
<?
}
?>



</div>
</body>
</html>
