<?php

$submoduleid=0;
include_once('common_tools.php');

if($userlogin==1)
{
html_header_to_show();

//echo "<br><br>loginnedin";

?>
 <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
 <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
 <script src="js/raphael-min.js" type="text/javascript"></script>
 <script src="js/morris/morris.min.js" type="text/javascript"></script>

<div class="container">
<br>
 <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
<?php
/// force create if not there daywise table -start
$tablex=" wifilog.`wifi_user_usage_".date('Y_m_d')."` ";
$createsql="CREATE TABLE IF NOT EXISTS ".$tablex." (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `logid` int(11) DEFAULT NULL,
  `create_by_user` varchar(250) NOT NULL,
  `create_on_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_type` varchar(250) NOT NULL,
  `user_live_full_date` date NOT NULL,
  `user_live_date` int(11) NOT NULL,
  `user_live_day` varchar(4) NOT NULL,
  `user_live_mon` int(11) NOT NULL,
  `user_live_year` int(11) NOT NULL,
  `user_live_hour` int(11) NOT NULL,
  `user_live_min` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_mobile` varchar(250) NOT NULL DEFAULT '',
  `user_mac` varchar(250) NOT NULL DEFAULT '',
  `user_ip` varchar(250) NOT NULL DEFAULT '',
  `user_eth` varchar(5) NOT NULL,
  `iptables_packets` bigint(11) NOT NULL DEFAULT '0',
  `iptables_bytes` bigint(11) NOT NULL DEFAULT '0',
  `modem_location_id` int(11) NOT NULL DEFAULT '0',
  `user_full_name` varchar(250) NOT NULL,
  `user_device_type` varchar(250) NOT NULL,
  `user_reg_browser_full_info` varchar(250) NOT NULL,
  `user_reg_browser` varchar(250) NOT NULL,
  `user_reg_device` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_reg_datetime` datetime NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `user_mac` (`user_mac`),
  KEY `iptables_packets` (`iptables_packets`),
  KEY `iptables_bytes` (`iptables_bytes`),
  KEY `user_id` (`user_id`),
  KEY `user_live_mon` (`user_live_mon`),
  KEY `user_live_year` (`user_live_year`),
  KEY `user_live_hour` (`user_live_hour`),
  KEY `user_live_min` (`user_live_min`),
  KEY `modem_location_id` (`modem_location_id`),
  KEY `user_live_full_date` (`user_live_full_date`),
  KEY `user_live_date` (`user_live_date`),
  KEY `user_live_day` (`user_live_day`),
  KEY `user_eth` (`user_eth`),
  KEY `user_mobile` (`user_mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

#print "\n $createsql \n";
$xresult = $mysqldblink->query($createsql);
/// force create if not there daywise table -end


$outx=0;
$sqlx="SELECT count(1) as countx FROM ( SELECT distinct `user_mac` FROM `wifilog`.`wifi_user_usage_".date('Y_m_d')."` ) z";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
$outx=$mrow[0];
}
echo $outx;
?>
                                        
                                    </h3>
                                    <p>
                                     Today's Users
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="?rtype=usersactive" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
<?php
$outx=0;
$sqlx="SELECT count(`user_mac_address`) as countx FROM `mac_user_info`";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
$outx=$mrow[0];
}
echo $outx;
?>

                                    </h3>
                                    <p>
                                       Total Registrations
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="?rtype=userreg" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        
<?php
$outx=0;
$sqlx="SELECT SUM( `iptables_bytes` )  FROM `wifilog`.`wifi_user_usage_".date('Y_m_d')."` ";

//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
$outx=$mrow[0];
}
$outx=formatBytes($outx,0);
echo $outx;
?>

                                    </h3>
                                    <p>
                                        Today Usage
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="?rtype=userusage" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        
<?php

$outx=0;
$sqlx="SELECT SUM( `iptables_bytes` )  FROM `wifi_daily_usage` ";

//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
$outx=$mrow[0];
}
if($outx!=0 ){$outx=formatBytes($outx,0);}else{$outx="0";}
echo $outx;
?>



                                    </h3>
                                    <p>
                                        Total Usage
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="?rtype=dailydata" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

<?php
////////////////////////////////////////////////////////////////////////////////
/// User Activity - start 
if($_GET['rtype']=="usersactive")
{
$rtype=$_GET['rtype'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}
?>
<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="<?php echo $_GET['rtype']; ?>">
<div class="box box-primary">
	<div class="box-header">
<h3 class="box-title">Users Daywise Activity</h3>
<div style="float: right !important;">
    <div class="input-append date">
                <div class="input-daterange" id="datepicker" >
                    <input type="text" class="btn btn-default" style="color:red" name="startdate"  value="<? echo $startdate; ?>"/>
<button type="button" class="btn btn-default" onClick="document.myform.submit();return false;;">Go</button> 
<!-- to   <input type="text" class="input-small" name="enddate" value="<? echo $enddate; ?>"/> -->
                </div> 
            </div> </div>
</div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="specialchart" style="position: relative; height: 300px;"></div></div>
</div>
</form>

<h4 class="page-header">Users who were Active</h4>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>MAC</th>
<th>Name</th>
<th>Mobile</th>
<th>First Seen</th>
<th>Last Seen</th>
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
            
            });

$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],

"ajax": "view_reports_ajax_raw.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&rtype=<?php echo $rtype; ?>",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
return '<a href="?rtype=macview&macid='+data+'">'+data +'</a>';
},
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );




var table = $('#datadisplaybox').DataTable();
var globaleditcolumn=0;
var globaledituid=0;
$('#datadisplaybox tbody').on( 'click', 'td', function () {
var x=  table.cell (this).index().column ;
var y=  table.cell( this ).data();
globaleditcolumn=x;
} );
$('#datadisplaybox tbody').on( 'click', 'tr', function () {
if ( $(this).hasClass('selected') ) {
$(this).removeClass('selected');
} else {
table.$('tr.selected').removeClass('selected');
$(this).addClass('selected');
}
var d = table.row( this ).data();
globaledituid=d[1];
if(globaleditcolumn==1){
window.location.href="view_mac_report.php?maccheck="+globaledituid;
}
} );


} );


 var userarea = new Morris.Area({
        element: 'specialchart',
        resize: true,
        data: [
<?php
$outx=0;
$e=0;
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);

$sqlx="SELECT distinct count(`user_mac`),`user_live_hour` FROM
(
SELECT distinct `user_mac`,`user_live_hour` FROM `wifilog`.`wifi_user_usage_".$startdatex."`
) z GROUP BY `user_live_hour`
";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".$startdate." ".$mrow[1].":00:00', d1: ".$mrow[0]."},";
}
?>
        ],
xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1'],
        labels: [ 'Active Users'],
        lineColors: [ '#3c8dbc'],
        hideHover: 'auto'
    });
</script>

<?php
}
/// User Activity - end 
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
/// User Register - start
if($_GET['rtype']=="userreg")
{
$rtype=$_GET['rtype'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}

?>
<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="<?php echo $_GET['rtype']; ?>">
<div class="box box-primary">
        <div class="box-header">
<h3 class="box-title">Users Registered</h3>
</div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="specialchart" style="position: relative; height: 300px;"></div></div>
</div>
</form>
<h4 class="page-header">Users Registered Information</h4>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>MAC</th>
<th>Name</th>
<th>Mobile</th>
<th>Register</th>
<th>Verified/Active</th>
</tr>
</thead>
</table>

<br><br>&nbsp;
<!-- Custom tabs Charts end-->

<script>

$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],
"ajax": "view_reports_ajax_raw.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&rtype=<?php echo $rtype; ?>",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
return '<a href="?rtype=macview&macid='+data+'">'+data +'</a>';
},
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );

} );


 var userarea = new Morris.Area({
        element: 'specialchart',
        resize: true,
        data: [
<?php
$outx=0;
$e=0;
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);

$sqlx="
SELECT
main_date,
SUM(not_activeuser) as not_activeuser,
SUM(activeuser) as activeuser
FROM (
SELECT
 Date_Format( user_reg_datetime, '%Y-%m-%d' ) AS main_date ,
SUM(CASE WHEN `user_reg_active`= 0 THEN 1 ELSE 0 END) not_activeuser,
SUM(CASE WHEN `user_reg_active`= 1 THEN 1 ELSE 0 END) activeuser
FROM `mac_user_info`  WHERE Date_Format( user_reg_datetime, '%Y-%m-%d' ) IN (
SELECT DISTINCT Date_Format( user_reg_datetime, '%Y-%m-%d' ) AS main_date
FROM `mac_user_info`
) group by user_reg_datetime
) z group by main_date

";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".$mrow[0]."', d1: ".$mrow[2].",d2:".$mrow[1]."},";
}
?>
        ],
/* xLabels : "day", */
        xkey: 'y',
        ykeys: ['d1','d2'],
        labels: [ 'Registered Verified Users','Registered Not Verified Users'],
        lineColors: [ '#ffccdd','#ff0000'],
        hideHover: 'auto'
    });
</script>



<?php
}
/// User Register - end
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
/// User Usage - start
if($_GET['rtype']=="userusage")
{
$rtype=$_GET['rtype'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}
?>
<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="<?php echo $_GET['rtype']; ?>">
<div class="box box-primary">
        <div class="box-header">
<h3 class="box-title">Users Daywise Activity</h3>
<div style="float: right !important;">
    <div class="input-append date">
                <div class="input-daterange" id="datepicker" >
                    <input type="text" class="btn btn-default" style="color:red" name="startdate"  value="<?php echo $startdate; ?>"/>
<button type="button" class="btn btn-default" onClick="document.myform.submit();return false;;">Go</button>
<!-- to   <input type="text" class="input-small" name="enddate" value="<?php echo $enddate; ?>"/> -->
                </div>
            </div> </div>
</div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="specialchart" style="position: relative; height: 300px;"></div></div>
</div>
</form>
<h4 class="page-header">Users who were Active</h4>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>MAC</th>
<th>Name</th>
<th>Mobile</th>
<th>First Seen</th>
<th>Last Seen</th>
<th>Avg MB</th>
<th>Max MB</th>
<th>Total MB</th>
<th>Avg kbps</th>
<th>Max kbps</th>
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

            });

$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],
"ajax": "view_reports_ajax_raw.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&rtype=<?php echo $rtype; ?>",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
return '<a href="?rtype=macview&macid='+data+'">'+data +'</a>';
},
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );

} );


 var userarea = new Morris.Area({
        element: 'specialchart',
        resize: true,
        data: [
<?php
$outx=0;
$e=0;
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);

$sqlx="SELECT `user_live_hour`,ROUND(AVG( `iptables_bytes` )/(1024 * 1024),2) ,ROUND(MAX( `iptables_bytes` )/(1024 * 1024),2),ROUND(SUM( `iptables_bytes` )/(1024 * 1024),2) FROM
 `wifilog`.`wifi_user_usage_".$startdatex."`
 GROUP BY `user_live_hour`
";
#print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".$startdate." ".$mrow[0].":00:00', d1: ".$mrow[1].", d2: ".$mrow[2].", d3: ".$mrow[3]."},";
}

?>
        ],
xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1','d2','d3'],
       postUnits:'MB',
labels: ['Avg Data', 'MAX Data','Total Data'],
        lineColors: ['#39CCCC','#00a65a','#3c8dbc'],
        hideHover: 'auto'
    });
</script>

<?php
}
/// User Usage - end
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
/// User Usage - start
if($_GET['rtype']=="dailydata")
{
$rtype=$_GET['rtype'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}

?>
<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="<?php echo $_GET['rtype']; ?>">
<div class="box box-primary">
        <div class="box-header">
<h3 class="box-title">Daily Data Usage</h3>
</div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="specialchart" style="position: relative; height: 300px;"></div></div>
</div>
</form>
<h4 class="page-header">Daily Usage Information</h4>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Total Data Usage (MB)</th>
</tr>
</thead>
</table>

<br><br>&nbsp;
<!-- Custom tabs Charts end-->

<script>

$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],
"ajax": "view_reports_ajax_raw.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>&rtype=<?php echo $rtype; ?>",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
return '<a href="?rtype=userusage&startdate='+data+'">'+data +'</a>';
},
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );

} );



 var userarea = new Morris.Area({
        element: 'specialchart',
        resize: true,
        data: [
<?php
$outx=0;
$e=0;
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);

$sqlx="

SELECT `user_live_date`, ROUND( `iptables_bytes` /(1024 * 1024),2) FROM `wifi_daily_usage`
ORDER BY `wifi_daily_usage`.`user_live_date`  ASC

";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".$mrow[0]."', d1: ".$mrow[1]."},";
}
?>
        ],
 postUnits:'MB',
 xLabels : "day", 
        xkey: 'y',
        ykeys: ['d1'],
        labels: [ 'Total Data Usage'],
        lineColors: [ '#3eddcc'],
        hideHover: 'auto'


    });
</script>




<?php
}
/// User Usage - end
////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////
/// MAC User Usage - start
if($_GET['rtype']=="macview" && $_GET['macid']!="")
{
$rtype=$_GET['rtype'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
if($startdate==""){$startdate=date('Y-m-d');}
if($enddate==""){$enddate=date('Y-m-d');}
$macid=$_GET['macid'];
$macid=str_replace(" ","",$macid);
$macid=str_replace("'","",$macid);
$macid=str_replace(";","",$macid);

?>
<!-- Custom tabs Charts -->
<form name="myform" id="myform">
<input type="hidden" name="rtype" value="<?php echo $_GET['rtype']; ?>">
<div class="box box-primary">
        <div class="box-header">
<h3 class="box-title">Activity of MAC : <?php echo $_GET['macid']; ?></h3>
<div style="float: right !important;">
<!--     <div class="input-append date">
                <div class="input-daterange" id="datepicker" >
                    <input type="text" class="btn btn-default" name="startdate"  value="<?php echo $startdate; ?>"/>
<button type="button" class="btn btn-default" onClick="document.myform.submit();return false;;">Go</button> 
to   <input type="text" class="input-small" name="enddate" value="<?php echo $enddate; ?>"/> 
                </div>
            </div> </div> -->
</div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="specialchart" style="position: relative; height: 300px;"></div></div>
</div>
</form>
<h4 class="page-header">Acitivity in Details</h4>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Hour</th>
<th>Name</th>
<th>Mobile</th>
<th>First Seen</th>
<th>Last Seen</th>
<th>Avg MB</th>
<th>Max MB</th>
<th>Total MB</th>
<th>Avg kbps</th>
<th>Max kbps</th>
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

            });

$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,
// "columns": [ {"name": "Sr", "orderable": "false"}],
"ajax": "view_reports_ajax_raw.php?startdate=<?php echo $startdate;?>&enddate=<?php echo $enddate; ?>&rtype=<?php echo $rtype; ?>&macid=<?php echo $macid; ?>&",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
//return '<a href="?rtype=macview&macid='+data+'">'+data +'</a>';
return data;
},
"targets":1
}
,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

]
} );

} );

 var userarea = new Morris.Area({
        element: 'specialchart',
        resize: true,
        data: [
<?php
$macid=$_GET['macid'];
$macid=str_replace(" ","",$macid);
$macid=str_replace("'","",$macid);
$macid=str_replace(";","",$macid);
$sqlx="SELECT `user_live_date` , `user_mac` FROM `wifi_daily_users` WHERE `user_mac` = '".$macid."'";
$xresult = $mysqldblink->query($sqlx);
$subsql="";
$si=0;
while($mrow = $xresult->fetch_array()){
if($si!=0){$subsql=$subsql." UNION ";}
$si++;
$startdate=$mrow[0];
$startdatex=$startdate;
$startdatex=str_replace("-","_",$startdatex);
$subsql=$subsql."SELECT '".$startdate."' as userdate,`user_live_hour`,ROUND(AVG( `iptables_bytes` )/(1024 * 1024),2) as avgdata ,ROUND(MAX( `iptables_bytes` )/(1024 * 1024),2) as maxdata,ROUND(SUM( `iptables_bytes` )/(1024 * 1024),2) as subdata FROM  `wifilog`.`wifi_user_usage_".$startdatex."`  where `user_mac`='".$macid."' GROUP BY `user_live_hour` ";
//while loop over for date wise query builder
}

//print "\n\n ".$subsql."  \n\n";
######

$outx=0;
$e=0;

$sqlx="SELECT `userdate`,`user_live_hour`,`avgdata` ,`maxdata`,`subdata` FROM (".$subsql." ) z";
#print "\n<br>$sqlx<br>\n";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".$mrow[0]." ".$mrow[1].":00:00', d1: ".$mrow[2].", d2: ".$mrow[3].", d3: ".$mrow[4]."}\n";
$e++;
}

?>
        ],
// xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1','d2','d3'],
       postUnits:'MB',
labels: ['Avg Data', 'MAX Data','Total Data'],
        lineColors: ['#39CCCC','#00a65a','#3c8dbc'],
        hideHover: 'auto'
    });
</script>

<?php
}
/// MAC User Usage - end
////////////////////////////////////////////////////////////////////////////////





// For Homepgage for Report Done
if($_GET['rtype']=="")
{
?>
<!-- Custom tabs Charts -->
<div class="box box-primary"><div class="box-header"><h3 class="box-title">Today's Active Statistics</h3></div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="user-chart" style="position: relative; height: 300px;"></div></div></div>
<!-- Custom tabs Charts end-->

<!-- Custom tabs Charts -->
<div class="box box-primary"><div class="box-header"><h3 class="box-title">Data Statistics</h3></div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="data-chart" style="position: relative; height: 300px;"></div></div></div>
<!-- Custom tabs Charts end-->

<!-- Custom tabs Charts -->
<div class="box box-primary"><div class="box-header"><h3 class="box-title">Bandwidth Statistics</h3></div>
<div class="box-body chart-responsive"><div class="chart tab-pane active" id="bandwidth-chart" style="position: relative; height: 300px;"></div></div></div>
<!-- Custom tabs Charts end-->




<!-- Container div close -->

</div>

<script>
/*  Document at http://morrisjs.github.io/morris.js/lines.html */

 var userarea = new Morris.Area({ 
/*  var userarea = new Morris.Bar({ */
        element: 'user-chart',
        resize: true,
        data: [

<?php
$outx=0;
$e=0;
$sqlx="SELECT distinct count(`user_mac`),`user_live_hour` FROM 
(
SELECT distinct `user_mac`,`user_live_hour` FROM `wifilog`.`wifi_user_usage_".date('Y_m_d')."` 
) z GROUP BY `user_live_hour`
";
//print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".date('Y-m-d')." ".$mrow[1].":00:00', d1: ".$mrow[0]."},";
}
?>
        ],
xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1'],
        labels: [ 'Active Users'],
        lineColors: [ '#3c8dbc'],
        hideHover: 'auto'
    });


 var dataarea = new Morris.Area({ 
        element: 'data-chart',
        resize: true,
     data: [

<?php
$outx=0;
$e=0;
$sqlx="SELECT `user_live_hour`,ROUND(AVG( `iptables_bytes` )/(1024 * 1024),2) ,ROUND(MAX( `iptables_bytes` )/(1024 * 1024),2),ROUND(SUM( `iptables_bytes` )/(1024 * 1024),2) FROM
 `wifilog`.`wifi_user_usage_".date('Y_m_d')."`
 GROUP BY `user_live_hour`
";
#print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".date('Y-m-d')." ".$mrow[0].":00:00', d1: ".$mrow[1].", d2: ".$mrow[2].", d3: ".$mrow[3]."},";
}
?>

        ],
xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1','d2','d3'],
       postUnits:'MB', 

labels: ['Avg Data', 'MAX Data','Total Data'],
        lineColors: ['#39CCCC','#00a65a','#3c8dbc'],
        hideHover: 'auto'
    });

 var bandwidtharea = new Morris.Area({  
        element: 'bandwidth-chart',
        resize: true,
        
    data: [

<?php
$outx=0;
$e=0;
$sqlx="SELECT `user_live_hour`,ROUND(((AVG( `iptables_bytes` )*8)/3600)/1024,2) ,ROUND(((MAX( `iptables_bytes`)*8)/3600)/1024,2),ROUND(((SUM( `iptables_bytes` )*8)/3600)/1024,2) FROM
 `wifilog`.`wifi_user_usage_".date('Y_m_d')."`
 GROUP BY `user_live_hour`
";
#print "<br>$sqlx<br>";
$xresult = $mysqldblink->query($sqlx);
while($mrow = $xresult->fetch_array()){
if($e!=0){print ",";}
print " {y: '".date('Y-m-d')." ".$mrow[0].":00:00', d1: ".$mrow[1].", d2: ".$mrow[2].", d3: ".$mrow[3]."},";
}
?>

        ],
xLabels : "hour",
        xkey: 'y',
        ykeys: ['d1','d2','d3'],
       postUnits:'Kbps',

labels: ['Average Bandwidth', 'Max Bandwidth','Total Bandwidth'],
        lineColors: ['#932ab6','#f56954','#00a65a'],
        hideHover: 'auto'
    })
.on('click', function(i, row){
//console.log(i, row);
})
;



</script>


<?php
// for no rtype --end -- only for homepage
}

// Userlogin done
}
html_footer_to_show();

?>
