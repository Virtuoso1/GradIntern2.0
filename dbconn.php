<?php
$host = "127.0.0.1";     
$port = "3306";          
$pass = "";              
$dbname = "grad";
$user = "root";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
