<?
$submoduleid=15;
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

"ajax": "app_login_ajax_data_raw.php",
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
window.location.href="app_login_edit_users.php?uid="+globaledituid;
}
} );


} );

function addrow()
{
window.location.href="app_login_add_users.php";

}

</script>
<div class="container">
<h4 class="page-header"><?=$moduletitle?></h4> 
<div style="float:right;padding:5px;"><button onclick="addrow();return false;">Add New User</button></div>
<table id="datadisplaybox" class="display responsive" cellspacing="0" width="100%">
<thead>
<tr>
<th>Sr</th>
<th>UID</th><th>Login Name</th><th>Full Name</th><th>Contact</th><th>Active User</th></tr>
</thead>
</table>
</div>
<?
}

html_footer_to_show();
?>
