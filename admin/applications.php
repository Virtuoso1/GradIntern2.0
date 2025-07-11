<?php
session_start();
require "../dbconn.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("
    SELECT a.id, s.s_name, i.title, a.application_status, a.applied_at 
    FROM application a
    JOIN student s ON a.student_id = s.id
    JOIN internship i ON a.internship_id = i.id
");
?>

<!DOCTYPE html>
<html>
<head><title>Applications</title><link rel="stylesheet" href="../static/style.css"></head>
<body>
  <h2>Internship Applications</h2>
  <table border="1">
    <tr><th>Student</th><th>Internship</th><th>Status</th><th>Applied At</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['s_name']) ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['application_status']) ?></td>
        <td><?= htmlspecialchars($row['applied_at']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
