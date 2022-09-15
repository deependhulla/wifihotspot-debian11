<?

$ebdbname="wifihotspot";
$ebdbuser="root";
$ebdbhost="localhost";
$ebdbpass="techno02srv";

$smsusername="dbskkv.org";
$smsapikey="CC5875FC2B5DF95D72C86E16A1FA3";
$mysqldblink = new mysqli($ebdbhost, $ebdbuser, $ebdbpass, $ebdbname);

if($mysqldblink->connect_errno > 0){
    die('Unable to connect to database [' . $mysqldblink->connect_error . ']');
}

?>

