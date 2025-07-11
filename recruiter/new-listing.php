<?php
session_start();
include '../dbconn.php';

if (!isset($_SESSION['recruiter_id'])) {
    die("Access denied. Please log in.");
}

$recruiter_id = $_SESSION['recruiter_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $stipend = $_POST["stipend"];
    $location = $_POST["location"];
    $skills = $_POST["skills"];

    $stmt = $conn->prepare("INSERT INTO internship (title, internship_description, stipend, location, skills_required, recruiter_id)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssi", $title, $description, $stipend, $location, $skills, $recruiter_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recruiter Dashboard - New Internship</title>
    <link rel="stylesheet" href="../static/style.css">
  <style>
    a:hover{
      color:blue;
    }
  </style>
  </head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
    <a class='btn' href="logout.php">Logout</a>
  </header>  
  <a href="r_dashboard.php">Back to dashboard</a>

  <section class="form-section">
    <h2>Create New Internship</h2>
    <form method="POST"  class="form" action="">
        <input type="text" name="title" placeholder="Internship Title" required>
        <textarea name="description" placeholder="Internship Description" required></textarea>
        <input type="text" name="stipend" placeholder="Stipend" required>
        <input type="text" name="location" placeholder="Location" required>
        <textarea name="skills" placeholder="Required Skills" required></textarea>
        <button class="btn" type="submit">Post Internship</button>
    </form>
</section>
    
</body>
</html>