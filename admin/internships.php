<?php
session_start();
require "../dbconn.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("
    SELECT i.id, i.title, i.location, i.stipend, r.company_name 
    FROM internship i
    LEFT JOIN recruiter r ON i.recruiter_id = r.id
");
?>

<!DOCTYPE html>
<html>
<head><title>Internships</title><link rel="stylesheet" href="../style.css"></head>
<body>
  <h2>Internship Listings</h2>
  <table border="1">
<tr><th>Title</th><th>Location</th><th>Stipend</th><th>Posted By</th><th>Action</th></tr>

  <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['location']) ?></td>
        <td><?= htmlspecialchars($row['stipend']) ?></td>
        <td><?= htmlspecialchars($row['company_name']) ?></td>
        <td>
            <form method="POST" action="delete_internship.php" onsubmit="return confirm('Are you sure you want to delete this internship?');">
              <input type="hidden" name="internship_id" value="<?= $row['id'] ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
