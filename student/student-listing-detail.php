<?php
include "../dbconn.php";
if(isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("SELECT * FROM internship WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $internship = $result->fetch_assoc();
  if (!$internship) {
    echo "No internship found with ID $id";
    exit;
}

} else {
  echo "No listing selected.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $internship['title']; ?> - Internship Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <main class="detail-page">
    <h2><?php echo $internship['title']; ?></h2>
    <p><strong>Location:</strong> <?php echo $internship['location']; ?></p>
    <p><strong>Description:</strong> <?php echo $internship['internship_description']; ?></p>
    <p><strong>Skills Required:</strong> <?php echo $internship['skills_required']; ?></p>
    <p><strong>Stipend:</strong> <?php echo $internship['stipend']; ?></p>
    <p><strong>Posted Date:</strong> <?php echo $internship['posted_date']; ?></p>


    <form action="apply.php" method="post">
        <input type="hidden" name="internship_id" value="<?php echo $internship['id']; ?>">
        <button type="submit" class="btn">Apply</button>
  </main>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
