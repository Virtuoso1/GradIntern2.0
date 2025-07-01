<?php
$host = '127.0.0.1:3307';
$db = 'grad';
$user = 'root';
$pass = '1604'; // update if needed

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
