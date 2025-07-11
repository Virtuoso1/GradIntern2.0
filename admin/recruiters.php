<?php
session_start();
require "../dbconn.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT id, r_name, email, company_name, company_website FROM recruiter");
?>

<!DOCTYPE html>
<html>
<head><title>Recruiters</title><link rel="stylesheet" href="../style.css"></head>
<body>
  <h2>Registered Recruiters</h2>
  <table border="1">
    <tr><th>Name</th><th>Email</th><th>Company</th><th>Website</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['r_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['company_name']) ?></td>
        <td><a href="<?= htmlspecialchars($row['company_website']) ?>" target="_blank">Visit</a></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
