<?php
$host = "localhost";
$user = "root";
$password = ""; // Leave blank if you're using XAMPP default
$database = "grad";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
