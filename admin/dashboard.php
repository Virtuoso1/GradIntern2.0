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
  <link rel="stylesheet" href="../static/style.css">
  <style>
    a{
      color: blue;
    }
    a:hover{
      color: black
    }
  </style>
</head>
<body><header class="header">
    <div class="logo">GradIntern</div>
    <a class='btn' href="logout.php">Logout</a>
  </header>
  <main class="listings-page">
  <h2>Welcome, Admin</h2>
  <ul>
    <li><a href="students.php">Manage Students</a></li>
    <li><a href="recruiters.php">Manage Recruiters</a></li>
    <li><a href="internships.php">Manage Internships</a></li>
    <li><a href="applications.php">View Applications</a></li>
  </ul>
</main>
</body>
</html>
