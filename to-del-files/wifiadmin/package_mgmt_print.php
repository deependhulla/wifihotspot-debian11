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


$getuid=$_REQUEST['puid'];


$rtype=$_REQUEST['rtype'];

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

$sqlxz11vvivv="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='PACKAGE_VALUE_1_TEXT'";
$mysqlresultxz11vvivv = $mysqldblink->query($sqlxz11vvivv);
if($mysqlrow11vvivv = $mysqlresultxz11vvivv->fetch_array()){
$pvalue1_config=$mysqlrow11vvivv['msg_data'];
}

$sqlxz11vvipp="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg`='PACKAGE_VALUE_2_TEXT'";
$mysqlresultxz11vvipp = $mysqldblink->query($sqlxz11vvipp);
if($mysqlrow11vvipp = $mysqlresultxz11vvipp->fetch_array()){
$pvalue2_config=$mysqlrow11vvipp['msg_data'];
}


if($rtype=="1"){

$mysqli="SELECT  `uid`,`value1`,`value2`, `user_access_plan_name`, `no_of_devices_allowed` FROM ( SELECT a.`uid`, a.`value1`,a.`value2`, b.`user_access_plan_name`, a.`no_of_devices_allowed` FROM `wifi_package_management` as a  ,`wifi_access_plan` as b WHERE a.`access_plan_id`= b.`uid` AND a.`uid` IN(".$getuid."))  z WHERE 1";
$mysqlresulti = $mysqldblink->query($mysqli);
while($mysqlrowi = $mysqlresulti->fetch_array()){
$getuidi=$mysqlrowi['uid'];

for($i=0;$i<count($getuid);$i++)
{
$value1=$mysqlrowi['value1'];
$value2=$mysqlrowi['value2'];
$user_access_plan_name=$mysqlrowi['user_access_plan_name'];
$no_of_devices_allowed=$mysqlrowi['no_of_devices_allowed'];
?>
<div class="container">
<div class="row pad-top-botm ">
               <h4 style="text-align: center;font-size: 25px;"><? echo  $comp_namei;?></h4>
                <p style="text-align: center;"><b>Wifi Internet Access</b></p>
                <p style="text-align: center;"><? echo $comp_addri;?></p>
              </div>
                <p style="text-align: center;font-size: 11px;"><? echo $invoice_xtrai;?></p>
                <p style="float: right;">Generated: <? echo date("d-m-y H:i:s");?></p>
<div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">

<table class="table table-striped table-bordered table-hover" style="margin-bottom: 2px;">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;"><?=$pvalue1_config;?></th>
                                    <td><?=$value1;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;"><?=$pvalue2_config;?></th>
                                    <td><?=$value2;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;">Plan name</th>
                                    <td><?=$user_access_plan_name;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;">Number of devices</th>
                                    <td><?=$no_of_devices_allowed;?></td>
                                </tr>
                        </tbody>
                        </table>
	
<hr style="border: 1px dotted black;">
</div>
</div>
</div>
</div>
<?
}
}

?>

<?

}

if($rtype=="2"){
$mysqli1="SELECT  `uid`,`value1`,`value2`, `user_access_plan_name`, `no_of_devices_allowed` FROM ( SELECT a.`uid`, a.`value1`,a.`value2`, b.`user_access_plan_name`, a.`no_of_devices_allowed` FROM `wifi_package_management` as a  ,`wifi_access_plan` as b WHERE a.`access_plan_id`= b.`uid` AND a.`uid` IN(".$getuid."))  z WHERE 1";
$mysqlresulti1 = $mysqldblink->query($mysqli1);
while($mysqlrowi1 = $mysqlresulti1->fetch_array()){
$getuidi1=$mysqlrowi1['uid'];

for($i=0;$i<count($getuid);$i++)
{
$value11=$mysqlrowi1['value1'];
$value21=$mysqlrowi1['value2'];
$user_access_plan_name1=$mysqlrowi1['user_access_plan_name'];
$no_of_devices_allowed1=$mysqlrowi1['no_of_devices_allowed'];
?>
<div class="container" style="width: 48%;float: left;">
<div class="row pad-top-botm ">
       <h4 style="text-align: center;font-size: 25px;"><? echo  $comp_namei;?></h4>
	<p style="text-align: center;"><b>Wifi Internet Access</b></p>
	<p style="text-align: center;"><? echo $comp_addri;?></p>
      </div>
                <p style="text-align: center;font-size: 11px;"><? echo $invoice_xtrai;?></p>
                <p>Generated: <? echo date("d-m-y H:i:s");?></p>
<div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="margin-bottom: 2px;">
                            <tbody>
                                <tr>
                                    <th style="width: 50%;"><?=$pvalue1_config;?></th>
                                    <td><?=$value11;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;"><?=$pvalue2_config;?></th>
                                    <td><?=$value21;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;" >Plan name</th>
                                    <td><?=$user_access_plan_name1;?></td>
                                </tr>
                                <tr>
                                    <th style="width: 50%;">Number of devices</th>
                                    <td><?=$no_of_devices_allowed1;?></td>
                                </tr>
                        </tbody>
                        </table>

<hr style="border: 1px dotted black;">
</div>
</div>
</div>
</div>

<?
}
}
}
?>
</body>
</html>
