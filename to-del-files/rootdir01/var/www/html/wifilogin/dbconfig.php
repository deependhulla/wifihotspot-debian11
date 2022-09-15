<?

$ebdbname="wifihotspot";
$ebdbuser="root";
$ebdbhost="localhost";
$ebdbpass="techno02srv";

$smsusername="technoinfotech";
$smsapikey="D3C11CEAF117BE157844F15D2EE87";
$mysqldblink = new mysqli($ebdbhost, $ebdbuser, $ebdbpass, $ebdbname);

if($mysqldblink->connect_errno > 0){
    die('Unable to connect to database [' . $mysqldblink->connect_error . ']');
}

?>

