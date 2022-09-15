<?
$submoduleid=2;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>

<div class="container">
<h4 class="page-header"><?=$moduletitle?></h4> 


</div>
<?
}

html_footer_to_show();
?>
