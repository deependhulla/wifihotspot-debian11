<?php

$ebdbname="wifihotspot";
$ebdbuser="mydbadmin";
$ebdbhost="localhost";
$ebdbpass="Geng0yoo";

$mysqldblink = new mysqli($ebdbhost, $ebdbuser, $ebdbpass, $ebdbname);

if($mysqldblink->connect_errno > 0){
    die('Unable to connect to database [' . $mysqldblink->connect_error . ']');
}

?>
