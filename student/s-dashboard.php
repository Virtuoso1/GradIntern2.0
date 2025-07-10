<?php
include('dbconn.php');
session_start();

// Fetch all internships
$query = "SELECT * FROM internship ORDER BY posted_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
      <link rel="stylesheet" href="../css/style.css">

   
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
        <a class='btn' href="s-notification.php">Updates</a>
    <a class='btn' href="logout.php">Logout</a>
  </header>

  <main class="listings-page">
    <h2>Available Internships</h2>
    <div class="card-grid">
      <div class="card">
        <h3>Software Engineering Intern</h3>
        <p>Company: TechCorp</p>
        <p>Location: New York</p>
        <a href="student-listing-detail.php" class="btn">View Details</a>
      </div>
      <div class="card">
        <h3>Marketing Intern</h3>
        <p>Company: MarketMinds</p>
        <p>Location: Remote</p>
        <a href="student-listing-detail.php" class="btn">View Details</a>
  </main>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
