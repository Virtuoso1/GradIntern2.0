<?php
  include '../dbconn.php';
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = htmlspecialchars(trim($_POST["sname"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $location = strtoupper(trim($_POST["location"]));
  

  $check = $conn->prepare("SELECT id FROM student WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows>0){
    echo "Email already registered.";
  }else{
    $stmt = $conn->prepare("INSERT INTO student (s_name, email, password, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $location);

    if ($stmt->execute()){
      header("Location: student-login.php");
      exit();
    }else{
      echo "Error: ". $stmt->error;
    }
    $stmt->close();
  }
  $check->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Sign Up - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css" />
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>

  <section class="form-section">
    <h2>Create Your Student Account</h2>
    <form class="form" action="" method = "POST">
      <input type="text" name="sname" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="text" name="location" placeholder="Location" required />
      <button type="submit" class="btn btn-secondary">Sign Up</button>
      <p>Already have an account? <a href="student-login.php">Log in here</a></p>
    </form>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
