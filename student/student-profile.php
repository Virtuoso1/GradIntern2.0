<?php
require '../dbconn.php';
session_start();

// Use session or fallback to a test ID
$student_id = $_SESSION['student_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $student_id) {
    $university = $_POST['university'] ?? '';
    $cv_path = '';

    // Handle file upload
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
        $uploadDir = '../uploads/cvs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $cv_filename = time() . "_" . basename($_FILES['cv']['name']);
        $cv_path = $uploadDir . $cv_filename;
        move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);
    }

    // Prepare and execute update query
    if ($cv_path) {
        $stmt = $conn->prepare("UPDATE students SET university = ?, cv_path = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ssi", $university, $cv_path, $student_id);
        } else {
            die("Prepare failed: " . $conn->error);
        }
    } else {
        $stmt = $conn->prepare("UPDATE students SET university = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $university, $student_id);
        } else {
            die("Prepare failed: " . $conn->error);
        }
    }

    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile: " . $stmt->error;
    }
}

// Fetch profile details
$stmt = $conn->prepare("SELECT university, cv FROM student WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($university, $cv_path);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Profile - GradIntern</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <section class="form-section">
    <h2>My Profile</h2>

    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form class="form" method="POST" enctype="multipart/form-data">
      <input type="text" placeholder="Full Name" value="Jane Doe" />
      <input type="email" placeholder="Email" value="jane@example.com" />
      <input type="text" placeholder="Location" value="Lagos, Nigeria" />
      <textarea placeholder="Skills (comma-separated)">HTML, CSS, JS</textarea>

      <!-- New dynamic fields -->
      <input type="text" name="university" placeholder="University" value="<?= htmlspecialchars($university) ?>" required />
      <label>Upload CV (PDF):</label>
      <input type="file" name="cv" accept=".pdf" />

      <button class="btn btn-secondary" type="submit">Update Profile</button>
    </form>

    <?php if (!empty($cv_path)) : ?>
      <p><strong>CV:</strong> <a href="<?= htmlspecialchars($cv_path) ?>" target="_blank">Download</a></p>
    <?php endif; ?>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
