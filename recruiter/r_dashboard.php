<?php
session_start();
include '../dbconn.php';

if (!isset($_SESSION['recruiter_id'])) {
    header("Location: recruiterlogin.php");
    exit();
}

$recruiter_id = $_SESSION['recruiter_id'];

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
  <header class="header">
    <div class="logo">GradIntern</div>
    <a class='btn' href="logout.php">Logout</a>


  </header>

  <main class="listings-page">
    <h2>My Internship Listings</h2>
    <a href="new-listing.php">
    <button class="btn">Create New Listing</button>
    </a>
    <div class="card-grid">
      <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <a href="applicant-details.php?id=<?php echo $row['id']; ?>">
              <strong><?php echo htmlspecialchars($row['title']); ?></strong> <br/>
              <?php echo htmlspecialchars($row['location']); ?> <br/>
              Ksh <?php echo number_format($row['stipend']); ?>
      </a>
              <br/><form method="POST" action="deletelisting.php" style="display:inline; float:right;" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                  <input type="hidden" name="listing_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" class="delete-btn">Delete</button>
              </form>
         </div> 
      <?php endwhile; ?>
    </div>
  </main>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
