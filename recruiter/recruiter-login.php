<?php
  session_start();
  include '../dbconn.php';
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]);

    $stmt = $conn->prepare("SELECT id, r_name, password FROM recruiter WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['recruiter_id'] = $id;
            $_SESSION['recruiter_name'] = $name;

            if ($remember) {
                setcookie("recruiter_email", $email, time() + (3 * 24 * 60 * 60));
            }

            header("Location: r_dashboard.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not registered.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recruiter Login - GradIntern</title>
  <link rel="stylesheet" href="../static/style.css">
</head>
<body>
  <header class="header">
    <div class="logo">GradIntern</div>
  </header>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

  <section class="form-section">
    <h2>Recruiter Login</h2>
    <form class="form" action='' method = 'POST'>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <label style="display: inline-flex; align-items: center;">
        <input type="checkbox" name="remember" style="margin-right: 8px;"> Remember Me</label><br>
      <button class="btn btn-secondary">Log In</button>
      <p>Don't have an account? <a href="recruiter-signup.php">Sign up here</a></p>
    </form>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
