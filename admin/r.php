<?php
include "../dbconn.php";

$username = 'pow';
$password = password_hash('valet', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
echo "Admin created.";
?>
