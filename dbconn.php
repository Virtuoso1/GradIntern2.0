<?php
$host = '127.0.0.1:3306';
$db = 'grad';
$user = 'root';
$pass = ''; // update if needed

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
