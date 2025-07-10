<?php
include "../dbconn.php";

$result = $conn->query("SELECT * FROM internship");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Internships - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css" />
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
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="card">
        <h3><?php echo $row['title']; ?></h3>
        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>

        <a class="btn" href="student-listing-detail.php?id=<?php echo $row['id']; ?>">View Details</a>
      </div>
    <?php endwhile; ?>
    </div>
  </main>
  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
