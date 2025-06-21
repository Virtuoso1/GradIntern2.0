<?php
  include '../dbconn.php';
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = htmlspecialchars(trim($_POST["rname"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $cname = htmlspecialchars(trim($_POST["cname"]));
    $web = htmlspecialchars(trim($_POST["web"]));
    $loc = htmlspecialchars(trim($_POST["loc"]));
    $password = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
  

  $check = $conn->prepare("SELECT id FROM recruiter WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows>0){
    $error= "Email already registered.";
  }else{
    $stmt = $conn->prepare("INSERT INTO recruiter (r_name, email, password, phone_no, location, company_name, company_website) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $password, $phone, $loc, $cname, $web);

    if ($stmt->execute()){
      header("Location: recruiter-login.php");
      exit();
    }else{
      $error = $stmt->error;
    }
    $stmt->close();
  }
  $check->close();
  $conn->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recruiter Signup - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css">
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <section class="form-section">
    <h2>Recruiter Sign Up</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form class="form" action='' method= 'POST'>
      <input type="text" name='rname' placeholder="Recruiter Name" required>
      <input type="email" name='email' placeholder="Email" required>
      <input type="text" name='phone' placeholder="Phone Number" required>
      <input type="text" name='cname' placeholder="Company Name" required>
      <input type="text" name='web' placeholder="Company Website" required>
      <input type="text" name='loc' placeholder="Location" required>
      <input type="password" name='pwd' placeholder="Password" required>
      <button class="btn btn-secondary">Create Account</button>
      <p>Already have an account? <a href="recruiter-login.php">Log in here</a></p>
    </form>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
