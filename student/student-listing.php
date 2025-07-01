
<?php
// student-listings.php

$conn = new mysqli("127.0.0.1:3307", "root", "1604", "grad");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM internship");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Internship Listings - GradIntern</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <main>
    <h2>Available Internships</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="listing-card">
        <h3><?php echo $row['title']; ?></h3>
        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>

        <!-- ✅ View Details Button with correct file name and ID -->
        <a href="student-listing-detail.php?id=<?php echo $row['id']; ?>">View Details</a>
      </div>
    <?php endwhile; ?>
  </main>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>