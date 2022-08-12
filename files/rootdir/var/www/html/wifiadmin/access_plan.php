<?php
$submoduleid=11;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>
<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
$('#datadisplaybox').dataTable( {
"processing": true,
"responsive": true,
"serverSide": true,
//stateSave: true,

// "columns": [ {"name": "Sr", "orderable": "false"}],

"ajax": "access_plan_ajax_data_raw.php",
 "columnDefs": [
 {
"render": function ( data, type, row ) {
return '<a href="#">'+data +'</a>';
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
window.location.href="access_plan_edit.php?uid="+globaledituid;
}
} );


} );
function add_access_plan_row()
{
window.location.href="access_plan_add.php";

}


</script>
<div class="container">
<h4 class="page-header"><?php echo $moduletitle;?></h4> 
<div style="float:right;padding:5px;"><button onclick="add_access_plan_row();return false;">Add New Access Plan</button></div>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>UID</th><th>Plan Name</th><th>Validity Period (in minutes)</th><th>Active</th><th>Traffic Limit(MB)<th>Traffic Reset(MB)</th><!--<th>Upload Speed(kbps)</th>--><th>Download Speed(kbps)</th><th>Traffic Limit(Days)</th><th>Plan Price(INR)</th><!--<th>Traffic Limit</th><th>Basic Upload</th><th>Basic Download</th>--></tr>
</thead>
</table>
</div>
<?php
}

html_footer_to_show();
?>
