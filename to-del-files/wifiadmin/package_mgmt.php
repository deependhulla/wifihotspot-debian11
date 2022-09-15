<?
$submoduleid=24;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{

$mainsql="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_1_TEXT'";

$mysqlresult = $mysqldblink->query($mainsql);
while($mysqlrow = $mysqlresult->fetch_array()){
$val1 = $mysqlrow['msg_data'];
}

$mainsql1="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_2_TEXT'";

$mysqlresult1 = $mysqldblink->query($mainsql1);
while($mysqlrow1 = $mysqlresult1->fetch_array()){
$val2 = $mysqlrow1['msg_data'];
}

$mainsql3="SELECT `msg_data` FROM `config_info` WHERE `type_of_msg` = 'PACKAGE_VALUE_3_TEXT'";
$mysqlresult3 = $mysqldblink->query($mainsql3);
while($mysqlrow3 = $mysqlresult3->fetch_array()){
$val3 = $mysqlrow3['msg_data'];
}


?>
<script type="text/javascript" language="javascript" class="init">
var globalvara="1";
//var checkValues = [];
$(document).ready(function() {

$('#btngo').on( 'click', function () {
var a = $('#actsearch').val();
globalvara = a;
console.log(globalvara);
table.ajax.reload();
} );





$('#datadisplaybox').dataTable( {
"pageLength": 50,
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],



"ajax": 

{
"url": "package_mgmt_ajax_data_raw.php",
"data": function ( d ) {
                d.vara = globalvara;
                // d.custom = $('#myInput').val();
                // etc
            },


},


 "columnDefs": [
 {
"render": function ( data, type, row ) {
if ( type === 'display' ) {
                        return '<input type="checkbox" name="checkboxlist" id="checkboxlist"  class="editor-active" value="'+ row[1] +'" >';
                    }
                    return data;
return '<a href="#">'+data +'</a>';
},
"targets":9 
}
,
{"render": function ( data, type, row ) {
return '<a href="#">'+data +'</a>';
},
"targets":1
}
,

 {
"render": function ( data, type, row ) {
return '<a href="#">'+data +'</a>';
},
"targets":8
}

,
{ "targets": 0, "orderable": false }
,{ "targets": 1, "visible": false }

],


} );

var table = $('#datadisplaybox').DataTable();


var globaleditcolumn=0; 
var globaledituid=0;
var globaledituidmac=0; 
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
globaledituidmac=d[8];
if(globaleditcolumn==1){  
window.location.href="package_mgmt_edit.php?uid="+globaledituid;
}
if(globaleditcolumn==8){
//window.location.href="index.php?rtype=macview&macid="+globaledituidmac;
window.location.href="total_users_pkg_mgmt.php?uid="+globaledituid;
}


if(globaleditcolumn==9){ 

var glob = [];
glob=d[1];

$('#btnprint').click(function(){
var dta = $('#printrow').val();
var final = [];
    $('.editor-active:checked').each(function(){        
        final.push($(this).val());
    });
if(dta == ''){
alert("Please Select Print Row");
$('#printrow').focus();
return false;
}
window.location.href="package_mgmt_print.php?puid="+final+"&rtype="+dta; 

});

}

} );


} );
function add_access_plan_row()
{
window.location.href="package_mgmt_add.php";

}


</script>
<div class="container">
<h4 class="page-header"><?=$moduletitle?>

<span style="float:right;"><button onclick="add_access_plan_row();return false;">Add New Package</button></span>
</h4> 
<div style="float:right;padding:5px;">
 <select name="actsearch" id="actsearch">
  <option value="">All Packages</option>
  <option value="1" selected>Active Packages</option>
  <option value="0">Inactive Packages</option>
</select> 
<button id="btngo">Show</button>
<br/>
</div>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>

<th>Sr</th>
<th>UID</th><th>Value1 - (<?php echo $val1;?>)</th><th>Value2 - (<?php echo $val2;?>)</th><th>Value3 - (<?php echo $val3;?>)</th><th>Plan Name</th><th>Number of devices<th>Package Active</th><th>Registered User</th><th>Select</th></tr>
</thead>
</table>
<br/>
<div style="float: right;">
<select name="printrow" id="printrow" style="float: left;">
  <option value="">Select Print row</option>
  <option value="1">Print Single Per Row</option>
  <option value="2">Print Double Per Row</option>
</select>
<button id="btnprint" style="float:right;">Print Package</button>
</div>
</div>
<?
}

html_footer_to_show();
?>
