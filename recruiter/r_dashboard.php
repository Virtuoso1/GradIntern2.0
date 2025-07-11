<?php
session_start();
include '../dbconn.php';

if (!isset($_SESSION['recruiter_id'])) {
    header("Location: recruiterlogin.php");
    exit();
}

$recruiter_id = $_SESSION['recruiter_id'];
$recruiter_name = $_SESSION['recruiter_name']; // assuming this is set at login

$sql = "SELECT id, title, location, stipend FROM internship WHERE recruiter_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recruiter_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Listings - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="header-left">
      <div class="logo">GradIntern</div>
      <div class="welcome">Welcome, <?php echo htmlspecialchars($recruiter_name); ?>!</div>
    </div>
    <div class="header-right">
      <a class='btn' href="logout.php">Logout</a>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="dashboard-main">
    <h2 class="section-title">My Internship Listings</h2>
    
    <div style="text-align:center; margin-bottom: 1.5rem;">
      <a href="new-listing.php" class="btn btn-secondary">+ Create New Listing</a>
    </div>

    <div class="card-grid">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <a href="applicant-details.php?id=<?php echo $row['id']; ?>">
              <h3 class="internship-title"><?php echo htmlspecialchars($row['title']); ?></h3>
              <p class="internship-location"><strong>📍</strong> <?php echo htmlspecialchars($row['location']); ?></p>
              <p><strong>💰</strong> Ksh <?php echo number_format($row['stipend']); ?></p>
            </a>
            <form method="POST" action="deletelisting.php" style="margin-top: 0.5rem;" onsubmit="return confirm('Are you sure you want to delete this listing?');">
              <input type="hidden" name="listing_id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="no-internships">You have no internship listings yet.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
