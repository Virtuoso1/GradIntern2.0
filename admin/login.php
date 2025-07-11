<?php
session_start();
include "../dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $hashed_password);
    
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['admin_id'] = $admin_id;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <header class="header">
    <div class="logo">GradIntern</div>
  </header>
    <section class="form-section">
  <h2>Admin Login</h2>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form class="form" method="POST">
    <input type="text" name="username" placeholder="Username" required /><br/>
    <input type="password" name="password" placeholder="Password" required /><br/>
    <button type="submit" class="btn btn-secondary">Login</button>
  </form>
</section>
</body>
</html>
