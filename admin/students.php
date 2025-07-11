<?php
session_start();
require "../dbconn.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT id, s_name, email, university, phone_no FROM student");
?>

<!DOCTYPE html>
<html>
<head><title>Students</title><link rel="stylesheet" href="../style.css"></head>
<body>
  <h2>Registered Students</h2>
  <table border="1">
    <tr><th>Name</th><th>Email</th><th>University</th><th>Phone</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['s_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['university']) ?></td>
        <td><?= htmlspecialchars($row['phone_no']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
