<?

$ebdbname="wifihotspot";
$ebdbuser="wifihotspot";
$ebdbhost="192.168.3.254";
$ebdbpass="n9Rxz9NRvdtWB5tG";

$mysqldblink = new mysqli($ebdbhost, $ebdbuser, $ebdbpass, $ebdbname);

if($mysqldblink->connect_errno > 0){
    die('Unable to connect to database [' . $mysqldblink->connect_error . ']');
}

?>
