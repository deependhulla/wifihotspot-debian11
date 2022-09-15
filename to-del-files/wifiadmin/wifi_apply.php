<?
$submoduleid=2;
include_once('common_tools.php');

if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{
?>

<div class="container">
<h4 class="page-header">WIFI Apply Rules</h4> 

<?
if($_GET['applynow']=="yes")
{
print "Appying...please wait...<br>";

$cmdx=" /usr/bin/elinks -dump -eval 'set connection.ssl.cert_verify = 0' https://127.0.0.1:8383/wifidirect/index.cgi?wifiupdate=yes";
$xx=`$cmdx`;
print "Applied Succesfully.";
}
else
{
?>
<form name="aa" action="">
<input type=hidden name=applynow value="yes">
 <button class="btn btn-lg btn-primary btn-block" type="submit" name="reg_submit">Click here to Apply WIFI Rules</button>
</form>
<?
}
?>
</div>

<?
}
html_footer_to_show();
?>
