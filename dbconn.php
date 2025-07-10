<?php
$host = "127.0.0.1";     
$port = "3306";          
$pass = "";              
$dbname = "grad";
$user = "root";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
