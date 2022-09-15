<?php
include_once('dbinfo.php');

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('<sub style="font-size:12px">B</sub>', '<sub style="font-size:12px">KB</sub>', '<sub style="font-size:12px">MB</sub>', '<sub style="font-size:12px">GB</sub>', '<sub style="font-size:12px">TB</sub>','<sub style="font-size:12px">PB</sub>','<sub style="font-size:12px">EB</sub>');

    //$dvdx= round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
$dvdy=round( pow(1024, $base - floor($base)), $precision); 
if(is_nan($dvdy)){$dvdy=0;}
    $dvdx= $dvdy. $suffixes[floor($base)];
    return $dvdx;
}

$userlogin=0;
$userloginname="";
$userloginid=0;
$apptitle="";
$createbyuser="";
$createondate="";
$accessokformodule=0;
$moduletitle="";
function csx($dvds)
{
global $mysqldblink;
$dvds = mysqli_real_escape_string($mysqldblink, $dvds);
return $dvds;
}

#### logouot logic start
if($_GET['logoutnow'] =="yes")
{
$_COOKIE["usertoauto"]="";
setcookie ("usertoauto", "" );
$userlogin=0;
?>
<center>
<br><div class="container">
<div class="alert alert-success">You have succesfully logged out</div>
</div></center>
<?php
}
#### logouot logic end

#### check for user auth from loginform start
if($_POST['loginnow'] =="yes")
{
$usernamex=$_POST['appsusername'];
$usernamey=$_POST['appspass'];
$usernamez=$_POST['appsrem'];
$usernamex = mysqli_real_escape_string($mysqldblink, $usernamex);
$usernamex=str_replace(" ","",$usernamex);
$usernamey=str_replace(" ","",$usernamey);
$ipblocklist="";
if($usernamex !="" )
{
$sqlx="SELECT `login_name`,`uid`,`create_by_user`,`create_on_date`,`login_ip`  FROM `app_login_info` WHERE `login_name`  = '".$usernamex."' AND `login_pass` = '".$usernamey."'  && `login_active` =1";
$mysqlresult = $mysqldblink->query($sqlx);

while($mysqlrow = $mysqlresult->fetch_assoc()){
$userlogin=1;
$ipblocklist=$mysqlrow['login_ip'];
#print "aaaaaaaa";
$userloginid=$mysqlrow['uid'];
#print "aaaaaaaa".$userloginid;
$userloginname=$mysqlrow['login_name'];
$createbyuser=$mysqlrow['create_by_user'];
$createondate=$mysqlrow['create_on_date'];
}

$ipaddgot=$_SERVER['REMOTE_ADDR'];
if($userlogin==1 && $ipblocklist !="")
{
#print " --> $userlogin --> $ipblocklist --> $ipaddgot";
$userlogin=0;
$iplist=array();
$iplist=explode(",",$ipblocklist);
for($li=0;$li<sizeof($iplist);$li++)
{
#print "<br>".$iplist[$li];
if($ipaddgot==$iplist[$li]){$userlogin=1;}
}
}


// for REM start
$usertoautodetailsx=time()."---".$userloginid."---".time();
$usertoautodetails="";
$numearray = array('0','1','2','3','4','5','6','7','8','9','-');
$numdarray = array('K','S','T','J','U','Z','Q','X','G','W','L');
$exz=strlen($usertoautodetailsx);
for($xc=0;$xc<strlen($usertoautodetailsx);$xc++){$numdata = substr($usertoautodetailsx,$xc,1);$addxv="";for($ert=0;$ert<sizeof($numearray);$ert++)
{if($numearray[$ert]==$numdata){$addvx=$numdarray[$ert];}}$usertoautodetails=$usertoautodetails.$addvx;}
#print "xxxx -> $usertoautodetails ";
if($usernamez !="" && $userlogin==1)
{
setcookie ("usertoauto", $usertoautodetails , strtotime( '+1000 days' ), "/");
}
if($usernamez =="" && $userlogin==1)
{
setcookie ("usertoauto", $usertoautodetails );
}
// for REM end
}

if($userlogin==0)
{
?>
<center>
<br>
<div class="container">
<div class="alert alert-danger">
Please Enter Correct Username and Password or You are not allowed to access from this IP
</div></div>
</center>
<?php
}
}

#### check for user auth from loginform end

### chekc for cookie if not from loginform start
if($_POST['loginnow'] !="yes" && $userlogin==0)
{
// for REM START
$callcenterok=0;
if($_COOKIE["usertoauto"] !="")
{
$usertoautodetailsx=$_COOKIE["usertoauto"];
$usertoautodetails="";
$numearray = array('0','1','2','3','4','5','6','7','8','9','-');
$numdarray = array('K','S','T','J','U','Z','Q','X','G','W','L');
$exz=strlen($usertoautodetailsx);
for($xc=0;$xc<strlen($usertoautodetailsx);$xc++){$numdata = substr($usertoautodetailsx,$xc,1);$addxv="";for($ert=0;$ert<sizeof($numearray);$ert++)
{if($numdarray[$ert]==$numdata){$addvx=$numearray[$ert];}}$usertoautodetails=$usertoautodetails.$addvx;}
$cuserx=explode("---",$usertoautodetails);
$callcenterok=2;
if($cuserx[1]!="")
{
$sqlx="SELECT `login_name`,`uid`,`create_by_user` FROM `app_login_info` WHERE `uid`  = '".$cuserx[1]."'  && `login_active` =1 ";
$mysqlresult = $mysqldblink->query($sqlx);
while($mysqlrow = $mysqlresult->fetch_assoc()){
$userlogin=1;
$userloginid=$mysqlrow['uid'];
$userloginname=$mysqlrow['login_name'];
$createbyuser=$mysqlrow['create_by_user'];
}
}
}
// for REM End
}
### chekc for cookie if not from loginform end

if($userlogin==0){$apptitle="Login";}

// only for testing
#$userlogin=1;
#$userloginname="deepen.dhulla";

// Header common start 
function html_header_to_show()
{
global $sr,$apptitle,$appname,$appcompanyname,$userloginname,$submoduleid,$userlogin,$userloginname,$userloginid,$accessokformodule,$mysqldblink,$moduletitle;
$sr=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0"> -->

<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title><?php echo $apptitle." - ".$appname." - ".$appcompanyname; ?></title>
<link href="css/datepicker.css" rel="stylesheet">
<!--<script src="js/bootstrap-datepicker.js "></script>-->
<link href="css/bootstrap.min-blue.css" rel="stylesheet">
<link href="css/dashboard.css" rel="stylesheet">
<script src="js/ie10-viewport-bug-workaround.js"></script>
<!--[if lt IE 9]>
<![endif]-->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>
<link href="css/datepicker.css" rel="stylesheet">
<script src="js/bootstrap-datepicker.js "></script>
<script type="text/javascript" src="js/bootstrap-clockpicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="css/navbar.css">
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="js/navbar.js"></script>
<!-- <script type="text/javascript" language="javascript" src="ckeditor/ckeditor.js?a"></script> -->

</head>
<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="index.php"><?php echo $appname." - ".$appcompanyname; ?></a>
</div>
<?php
if($userlogin==1)
{
$accessokformodule=0;
?>
<div class="navbar-collapse collapse">
<ul class="nav navbar-nav navbar-right">
<li <?php if($submoduleid==0){echo 'class="active"';} ?> ><a href="index.php">Dashboard</a></li>


<?php
$sqlxu="SELECT a.`module_id`, a.`module_sname`, a.`module_fullname`, a.`module_phpuri` FROM `app_module_info` as a,`app_module_access` as b  WHERE   a.`module_primary_id` = 0 and b.`module_id`=a.`module_id` AND b.`login_name` = '".$userloginid."' order by a.`module_display_order_id` ASC";
#print "\n<hr> $sqlxu";

$mysqlresultu = $mysqldblink->query($sqlxu);
while($mysqlrowu = $mysqlresultu->fetch_assoc()){

?>
<li <?php if($submoduleid==$mysqlrowu['module_id']){echo 'class="active"';} ?> class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown" ><?php echo $mysqlrowu['module_sname']; ?><span class="caret caret-right"></span></a>
<?php

$sqlxua="SELECT a.`module_id`, a.`module_sname`, a.`module_fullname`, a.`module_phpuri` FROM `app_module_info` as a,`app_module_access` as b  WHERE   a.`module_primary_id` = ".$mysqlrowu['module_id']." and b.`module_id`=a.`module_id` AND b.`login_name` = '".$userloginid."' order by a.`module_display_order_id` ASC";
#print "\n<hr> $sqlxua";
$dropx=0;
$mysqlresultua = $mysqldblink->query($sqlxua);
while($mysqlrowua = $mysqlresultua->fetch_assoc()){
if($dropx==0){ print "<ul class=\"dropdown-menu\" role=\"menu\">";}
$dropx++;
if($mysqlrowua['module_id']==$submoduleid)
{
$moduletitle=$mysqlrowua['module_fullname'];
$accessokformodule=1;
}

?>
<li <?php if($submoduleid==$mysqlrowua['module_id']){echo 'class="uactive"';} ?> ><a href="<?php echo $mysqlrowua['module_phpuri']; ?>"><?php echo $mysqlrowua['module_sname']; ?></a>
<?php
}
if($dropx!=0){print "</ul>";}
print "</li>";

if($mysqlrowu['module_id']==$submoduleid)
{
$moduletitle=$mysqlrowu['module_fullname'];
$accessokformodule=1;
}

}

?>


<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userloginname; ?> <span class="caret"></span></a>
<ul class="dropdown-menu" role="menu">
<li><a href="changepassform.php">Change Password</a></li>
<li><a href="index.php?logoutnow=yes">Logout</a></li></ul>
</li>
</div>
<?php

}
?>
</div></div>
<?php
if($accessokformodule==0 && $userlogin==1 && $submoduleid>0)
{
print "<br><br><center><font color=red>Access to this module not allowed. </font></center>";
}

}
//Header Common end

// footer common start
function html_footer_to_show()
{
?>
</body></html>
<?php
}
// footer common end

/// if not login show form -start
if($userlogin==0)
{
html_header_to_show();
?>
<style>
.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
    <div class="container">
      <form class="form-signin" role="adminform" action="index.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
<input type="text" class="form-control" placeholder="Username" name="appsusername" value="<?php echo $_POST['appsusername']; ?>" required autofocus><br>        
<input type="password" class="form-control" placeholder="Password" name="appspass" required>
<div class="checkbox">
          <label><input type="checkbox" name="appsrem" value="remember-me" > Remember me </label>
        </div>
<input type="hidden" name="loginnow" value="yes">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
</div>
<center>
<div class="container">
<div class="alert alert-info">
<?php
include_once('lic.php');
?>
<!-- <b>Technoinfotech</b> Support Contract Ends On : <b><?php echo $supportdate; ?></b> -->
</div>
</div>
</center>
<?php
}
/// if not login show form -end
?>
