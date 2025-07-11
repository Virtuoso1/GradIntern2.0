<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: student-login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../static/style.css">
      <link rel="stylesheet" href="../static/style.css">

   
</head>
<body>
  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <div class="logo">GradIntern</div>
      <div class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</div>
    </div>
    <div class="header-right">
      <a class='btn' href="s-notification.php">Updates</a>
      <a class='btn' href="logout.php">Logout</a>
    </div>
  </header>

  <!-- MAIN -->
  <main class="listings-page">
    <h2>Available Internships</h2>
    <div class="card-grid">
      <?php
      include "../dbconn.php";
      $result = $conn->query("SELECT * FROM internship");
      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <div class="card internship-card">
          <h3><?php echo $row['title']; ?></h3>
          <p><strong>📍 Location:</strong> <?php echo $row['location']; ?></p>
          <a class="btn btn-secondary" href="student-listing-detail.php?id=<?php echo $row['id']; ?>">View Details</a>
        </div>
      <?php endwhile; else: ?>
        <p>No internships available at the moment.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
