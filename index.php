<?php
session_start();
include 'dbconn.php';

if (isset($_SESSION['student_id'])) {
    header("Location: student/s-dashboard.php");
    exit();
}

if (isset($_COOKIE['student_email'])) {
  $email = $_COOKIE['student_email'];
  $stmt = $conn->prepare("SELECT id FROM student WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name);
      $stmt->fetch();
      $_SESSION['student_id'] = $id;
      $_SESSION['student_name'] = $name;
    header("Location: student/s-dashboard.php");
    exit();}
    $stmt->close();
}

if (isset($_SESSION['recruiter_id'])) {
    header("Location: recruiter/r_dashboard.php");
    exit();
}

if (isset($_COOKIE['recruiter_email'])) {
  $email = $_COOKIE['recruiter_email'];
  $stmt = $conn->prepare("SELECT id FROM recruiter WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name);
      $stmt->fetch();
      $_SESSION['recruiter_id'] = $id;
      $_SESSION['recruiter_name'] = $name;
    header("Location: recruiter/r_dashboard.php");
    exit();}
    $stmt->close();
  }
  $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GradIntern - Find Your Perfect Internship</title>
  <link rel="stylesheet" href="static/style.css" />
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
    <nav class="navbar">
      <ul class="nav-links">
        <li><a href="student/student-login.php">Students</a></li>
        <li><a href="recruiter/recruiter-login.php">Companies</a></li>
      </ul>
      <div class="actions">
      </div>
    </nav>
  </header>

  <section class="hero with-bg">
    <div class="hero-overlay">
    <h1>Find Your Internship</h1>
    <p>Discover exciting internship opportunities tailored for recent graduates.</p>
    <a id="bin" class="btn" href="student/student-signup.php">Get Started</a>

    
  </div>
  </section>

  <section class="features">
    <h2>Why Choose GradIntern</h2>
    <div class="feature-grid">
      <div class="feature">
        <h3>Personalized Matches</h3>
        <p>Smart algorithms match you with ideal internships.</p>
      </div>
      <div class="feature">
        <h3>Verified Companies</h3>
        <p>Only trusted and vetted companies are listed.</p>
      </div>
      <div class="feature">
        <h3>Real-Time Updates</h3>
        <p>Instant alerts on application updates and new postings.</p>
      </div>
    </div>
  </section>

  <section class="how-it-works">
    <h2>How It Works</h2>
    <ol>
      <li>Create an account</li>
      <li>Build your profile</li>
      <li>Get matched and apply</li>
    </ol>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
