<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title></title>
</head>
<body>

<?
$submoduleid=22;
include_once('common_tools.php');
$getuid=$_REQUEST['uid'];
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];



$mysqlx="SELECT MIN(`create_on_date`) AS a, MAX(`create_on_date`) AS b FROM `wifi_live_plans` where `mac_uid` = '".$getuid."' ";
#print " $mysqlx ";
$mysqlresult = $mysqldblink->query($mysqlx);
while($mysqlrow = $mysqlresult->fetch_array()){
$mindate=$mysqlrow['a'];
$maxdate=$mysqlrow['b'];
$minstart= substr($mindate,0,10);
$maxend= substr($maxdate,0,10);
}

#print " --> $minstart --> $maxend "; 
if($startdate==""){$startdate=$minstart;}
if($enddate==""){$enddate=$maxend;}


if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}


?>
 <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
 <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
 <script src="js/raphael-min.js" type="text/javascript"></script>
 <script src="js/morris/morris.min.js" type="text/javascript"></script>

<div class="container">
<h4 class="page-header"></h4>

<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="deviceplanhistory">
<input type="hidden" name="uid" value="<?=$getuid?>">
<div class="box box-primary">
        <div class="box-header">
<h3 class="box-title">Plan History For Device ID:<? echo $getuid;?> </h3>
<div style="float: right !important;">
    <div class="input-append date">
                <div class="input-daterange" id="datepicker" >
                   From <input type="text" class="btn btn-default" style="color:red" name="startdate"  value="<?=$startdate?>"/>
 To   <input type="text" class="btn btn-default" style="color:red" name="enddate" value="<?=$enddate?>"/> 
<button type="button" class="btn btn-default" onClick="document.myform.submit();return false;">Go</button>
                </div>
            </div> </div>
</div>
<h5 class="box-title">Plan Summary from <? echo $startdate;?> to <? echo $enddate;?></h5>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="bar-chart" style="position: relative; height: 300px;"></div></div>
</div>
</form>

<div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 2px;">
                            <tbody>
                                <tr>
                                    <th>Plan Name</th>
                                    <th style="text-align: right;">Revenue</th>
                                </tr>
<?
$sqlxz11vv="SELECT DISTINCT c.`user_access_plan_name` FROM `wifi_live_plans` as a ,`mac_user_info` as b,`wifi_access_plan` as c WHERE a.`mac_uid` = b.`uid` AND  a.`plan_uid`= c.`uid` AND b.`uid` = '".$getuid."'  AND DATE(a.`create_on_date`) >= '".$startdate."' AND DATE(a.`create_on_date`) <= '".$enddate."'";
$mysqlresultxz11vv = $mysqldblink->query($sqlxz11vv);
while($mysqlrow11vv = $mysqlresultxz11vv->fetch_array()){
$user_access_plan_name=$mysqlrow11vv['user_access_plan_name'];



$sqlxz11vv11="SELECT SUM(a.`plan_price`) AS price_summary FROM `wifi_live_plans` as a  ,`mac_user_info` as b,`wifi_access_plan` as c WHERE a.`mac_uid` = b.`uid` AND  a.`plan_uid`= c.`uid` AND c.`user_access_plan_name` = '".$user_access_plan_name."' AND b.`uid`= '".$getuid."' AND DATE(a.`create_on_date`) >= '".$startdate."' AND DATE(a.`create_on_date`) <= '".$enddate."'";
$mysqlresultxz11vv11 = $mysqldblink->query($sqlxz11vv11);
while($mysqlrow11vv11 = $mysqlresultxz11vv11->fetch_array()){
$plan_price_summary=$mysqlrow11vv11['price_summary'];


?>

                                <tr>
                                    <td><? echo $user_access_plan_name;?></td>
                                    <td style="text-align: right;"><? echo $plan_price_summary;?></td>
                                </tr>
<?
$total_plan_price_summary += $plan_price_summary;
}
}
if($user_access_plan_name != ''){
?>

<tr>
<th>Total</th>
<th style="text-align: right;"><? echo $total_plan_price_summary;?></th>
</tr>
<?
} else {
?>
<tr>
<th colspan="3" style="text-align: center;">No data available</th>
</tr>
<?
}
?>
                                </tbody>
                                </table>
</div>
</div>
</div>



<br>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>Start Date</th>
<th>End Date</th>
<th>Create By User</th>
<th>Plan Name</th>
<th>Verify Type</th>
<th>Verify Info</th>
<th>Plan Price</th>
</tr>
</thead>
</table>

<br><br>&nbsp;
<!-- Custom tabs Charts end-->


<script>
            // When the document is ready
            $(document).ready(function () {

                $('.input-daterange').datepicker({
format: 'yyyy-mm-dd',
    startDate: '-3m',
                    todayBtn: "linked"
                });

                $('.input-daterange').datepicker({
format: 'yyyy-mm-dd',
    endDate: '-3m',
                    todayBtn: "linked"
                });


            });


$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],
"ajax": "device_plan_history_ajax_raw.php?startdate=<?=$startdate?>&enddate=<?=$enddate?>&rtype=deviceplanhistory&uid=<?=$getuid?>",
 "columnDefs": [
 {
/*"render": function ( data, type, row ) {
return '<a href="?rtype=deviceplanhistory&startdate='+data+'&enddate='+data+'">'+data +'</a>';
},*/
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );

} );

var userarea = new Morris.Bar({
element: 'bar-chart',
data: [

<?
$outx=0;
$e=0;
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$enddatex=$enddate;
$enddatex=str_replace("-","_",$enddatex);

$sqlxch="
SELECT DISTINCT c.`user_access_plan_name` FROM `wifi_live_plans` as a ,`mac_user_info` as b,`wifi_access_plan` as c WHERE a.`mac_uid` = b.`uid` AND  a.`plan_uid`= c.`uid` AND b.`uid` = '".$getuid."' AND DATE(a.`create_on_date`) >= '".$startdate."' AND DATE(a.`create_on_date`) <= '".$enddate."'";

$xresult = $mysqldblink->query($sqlxch);
while($mrow = $xresult->fetch_array()){
$pname_chart = $mrow['user_access_plan_name'];



$sqlxz11vv11ch="SELECT SUM(a.`plan_price`) AS price_summary FROM `wifi_live_plans` as a  ,`mac_user_info` as b,`wifi_access_plan` as c WHERE a.`mac_uid` = b.`uid` AND  a.`plan_uid`= c.`uid` AND c.`user_access_plan_name` = '".$pname_chart."' AND b.`uid` = '".$getuid."' AND DATE(a.`create_on_date`) >= '".$startdate."' AND DATE(a.`create_on_date`) <= '".$enddate."'";
$mysqlresultxz11vv11ch = $mysqldblink->query($sqlxz11vv11ch);
while($mysqlrow11vv11ch = $mysqlresultxz11vv11ch->fetch_array()){
$plan_price_summarych=$mysqlrow11vv11ch['price_summary'];

if($e!=0){print ",";}

print " {y: '".$pname_chart."', a: '".$plan_price_summarych."'},";
?>
<?
}
}
?>
        ],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Revenue']
});


</script>


</div>

</body>
</html>
<?
}



html_footer_to_show();
?>
