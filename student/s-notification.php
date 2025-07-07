<?php
session_start();
include '../dbconn.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: studentlogin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "
    SELECT 
        a.application_status,
        i.title,
        r.email AS recruiter_email
    FROM application a
    JOIN internship i ON a.internship_id = i.id
    JOIN recruiter r ON i.recruiter_id = r.id
    WHERE a.student_id = ?
    ORDER BY 
        CASE WHEN a.application_status = 'Accepted' THEN 0 ELSE 1 END,
        a.applied_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notifications - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css" />
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <main class="notifications-page">
    <h2>My Applications</h2>
    
    <?php if ($result->num_rows === 0): ?>
        <p>You haven't applied to any internships yet.</p>
    <?php else: ?>
        <?php while ($row = $result->fetch_assoc()): 
            $status = $row['application_status'];
            $class = strtolower($status);
        ?>
            <div class="application <?php echo $class; ?>">
                <strong>Internship:</strong> <?php echo htmlspecialchars($row['title']); ?><br>
                <strong>Status:</strong> <?php echo $status; ?><br>
    
                <?php if ($status === 'Accepted'): ?>
                    <strong>Recruiter Email:</strong> <?php echo htmlspecialchars($row['recruiter_email']); ?><br>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    
  </main>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
