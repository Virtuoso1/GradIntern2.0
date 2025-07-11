<?php
$host = "127.0.0.1";     
$port = "3307";          
$pass = "1604";              
$dbname = "grad";
$user = "root";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
