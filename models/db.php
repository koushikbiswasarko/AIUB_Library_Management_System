<?php
$host = '127.0.0.1';
$dbname = "aiub_library";
$dbuser = "root";
$dbpass = "";

function getConnection(){
    global $host, $dbname, $dbuser, $dbpass;

    $databaseConnection = mysqli_connect($host, $dbuser, $dbpass, $dbname);

    if (!$databaseConnection) {
        die("Database connection failed!");
    }

    mysqli_set_charset($databaseConnection, "utf8");
    return $databaseConnection;
}
?>
