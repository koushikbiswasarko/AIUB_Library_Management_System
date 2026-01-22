<?php
$host = '127.0.0.1';
$dbname = "aiub_library";
$dbuser = "root";
$dbpass = "";

function getConnection(){
    global $host, $dbname, $dbuser, $dbpass;
    $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);
    return $con;
}
?>
