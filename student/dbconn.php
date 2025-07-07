<?php
$host = '127.0.0.1:3308';
$db = 'grad';
$user = 'root';
$pass = ''; // update if needed

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
