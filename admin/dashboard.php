<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <h2>Welcome, Admin</h2>
  <ul>
    <li><a href="students.php">Manage Students</a></li>
    <li><a href="recruiters.php">Manage Recruiters</a></li>
    <li><a href="internships.php">Manage Internships</a></li>
    <li><a href="applications.php">View Applications</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
