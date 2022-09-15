<?
$submoduleid=19;
include_once('common_tools.php');
$maxdays=4;
$goterror="";
if($userlogin==1){html_header_to_show();}
if($userlogin==1 && $accessokformodule==1)
{

$tvalidcode=array();
$tvalidmsg=array();
$f=0;

#########################################################
if($_POST['myfun']=="newtodaysave")
{

for($e=0;$e<$maxdays;$e++)
{
$gotdatex=date('Y-m-d', strtotime("+".$e." day"));

$xw="tvalidcode".$e;
$xy="tvalidmsg".$e;
$tvalidcodeu=$_POST[$xw];
$tvalidmsgu=$_POST[$xy];
#print "<br><Br><hr> $xw ($tvalidcodeu)--> $xy ($tvalidmsgu)";
if($tvalidcode!="")
{
$gotx=0;
$sqlxz="SELECT `code_date` , `today_code`,`code_for_event` FROM `today_code_info` WHERE `code_date` = '".$gotdatex."' ";
#print "\ $sqlxz \n";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
$gotx=1;
}

if($gotx==0 )
{
$sqlx="INSERT INTO `wifihotspot`.`today_code_info` (`uid`, `logid`, `create_by_user`, `create_on_date`, `create_type`, `code_date`, `today_code`, `code_for_event`) VALUES (NULL, NULL, '".$userloginname."', NOW(), '', '".$gotdatex."', '".$tvalidcodeu."', '".$tvalidmsgu."')";
}
else
{
$sqlx="UPDATE `wifihotspot`.`today_code_info` SET `create_on_date` = NOW( ) , `today_code` = '".$tvalidcodeu."', `code_for_event` = '".$tvalidmsgu."' WHERE `today_code_info`.`code_date` =  '".$gotdatex."';";
}

#print "<hr>$sqlx";
$mysqlresult = $mysqldblink->query($sqlx);
if(mysqli_error($mysqldblink))
{
if($goterror!=""){$goterror=$goterror."&nbsp;&nbsp; ";}
#if($goterror==""){$goterror="Code already used :  ";}
if($tvalidcodeu!=""  ){
if($goterror==""){$goterror="Code already used :  ";}

$goterror=$goterror."".$tvalidcodeu."";
}
}

}

}
### only post work -done
}
#########################################
for($e=0;$e<$maxdays;$e++)
{
$gotdatex=date('Y-m-d', strtotime("+".$e." day"));

$tvalidcode[$e]="";
$tvalidmsg[$e]="";
$sqlxz="SELECT `code_date` , `today_code`,`code_for_event` FROM `today_code_info` WHERE `code_date` = '$gotdatex' ";
$mysqlresult = $mysqldblink->query($sqlxz);
while($mysqlrow = $mysqlresult->fetch_assoc()){
$tvalidcode[$e]=$mysqlrow['today_code'];
$tvalidmsg[$e]=$mysqlrow['code_for_event'];
}
### for loop over for maxday
}


?>

<div class="container">
<h4 class="page-header"><? echo $moduletitle." for  ".$maxdays." days"; ?></h4> 
<?

if($goterror!=""){
print "<div class=\"alert alert-danger\" >".$goterror."</div>";
}
?>
<script>
function todaygo()
{
var x="";
var y="";
var codeok=1;
var n=0;
var m=0;
<?
for($e=0;$e<$maxdays;$e++)
{
?>
x=document.myform.tvalidcode<?=$e?>.value;
y=document.myform.tvalidmsg<?=$e?>.value;
n = x.length;
m = y.length;
//alert('<?=$e?> '+n+' mmmm'+m);
if(n>0)
{
if(n<6 && codeok==1){codeok=0; document.myform.tvalidcode<?=$e?>.focus();}
if(m<6 && codeok==1){codeok=0; document.myform.tvalidmsg<?=$e?>.focus();}
}
<?
}
?>

if(codeok==0)
{
alert("Please enter a 6 char Alphanumeric Code (not a repeated one) and Proper Event Details( more than 6 char) too.");
}
else{
document.myform.submit();
}
}
</script>
<div class="row">
<form class="form-signin" method="POST" action=" <?php echo $_SERVER['PHP_SELF'];?>" role="form" id="myform" name="myform">
<input type=hidden name="myfun" value="newtodaysave">
<?
for($e=0;$e<$maxdays;$e++)
{
$gotdatex=date('Y-m-d', strtotime("+".$e." day"));


?>
<div class="col-md-6">

<?=$gotdatex?> Wifi Today-Access-Code <input type="text" name="tvalidcode<?=$e?>" class="form-control" placeholder="Today's Wifi-Acess Code (6 Char or more)" value="<?php echo $tvalidcode[$e]; ?>" autofocus required>
<?=$gotdatex?> Event Details <input type="text" name="tvalidmsg<?=$e?>" class="form-control" placeholder="Today's Event Details" value="<?php echo $tvalidmsg[$e]; ?>" autofocus required>

</div>
<?
}
?></div> 
<br>        <br><button class="btn btn-lg btn-primary btn-block" type="button" name="reg_submit" onClick="todaygo();return false;">Create Today's Code</button>
      </form>



</div>

<?
}



html_footer_to_show();
?>
