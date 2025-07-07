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
    <style>
        body {
            background-color: #f0f6ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #003366;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 950px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #004080;
            margin-bottom: 40px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #cce0ff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 51, 102, 0.1);
        }

        .card h2 {
            margin: 0;
            color: #004080;
        }

        .card p {
            margin: 8px 0;
        }

        .view-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: #005cbf;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .view-btn:hover {
            background-color: #004999;
        }
    </style>
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
