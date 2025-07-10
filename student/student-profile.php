<?php
require '../dbconn.php';
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if student is logged in
$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    die("User not logged in.");
}

$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $university = $_POST['university'] ?? '';
    $phone_no = $_POST['phone_no'] ?? '';
    $skills = $_POST['skill_description'] ?? '';
    $cv_path = '';

    // Handle file upload
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
        $uploadDir = '../uploads/cvs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $cv_filename = time() . "_" . basename($_FILES['cv']['name']);
        $cv_path = $uploadDir . $cv_filename;
        if (!move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path)) {
            $error = "Failed to upload CV.";
        }
    }

    // Update DB only if no upload error
    if (!$error) {
        if ($cv_path) {
            $stmt = $conn->prepare("UPDATE student SET university = ?, phone_no = ?, skill_description = ?, cv = ? WHERE id = ?");
            if (!$stmt) die("Prepare failed: " . $conn->error);
            $stmt->bind_param("ssssi", $university, $phone_no, $skills, $cv_path, $student_id);
        } else {
            $stmt = $conn->prepare("UPDATE student SET university = ?, phone_no = ?, skill_description = ? WHERE id = ?");
            if (!$stmt) die("Prepare failed: " . $conn->error);
            $stmt->bind_param("sssi", $university, $phone_no, $skills, $student_id);
        }

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Fetch existing student details
$stmt = $conn->prepare("SELECT university, phone_no, skill_description, cv FROM student WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($university, $phone_no, $skills, $cv_path);
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

    <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>
    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form class="form" method="POST" enctype="multipart/form-data">
      <input type="text" name="phone_no" placeholder="Phone No" value="<?= htmlspecialchars($phone_no) ?>" required />

      <textarea name="skill_description" placeholder="Skills (comma-separated)" required><?= htmlspecialchars($skills) ?></textarea>

      <input type="text" name="university" placeholder="University" value="<?= htmlspecialchars($university) ?>"/>

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
