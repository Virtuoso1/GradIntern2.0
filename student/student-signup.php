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
    <form class="form">
      <input type="text" placeholder="Full Name" required />
      <input type="email" placeholder="Email" required />
      <input type="password" placeholder="Password" required />
      <input type="text" placeholder="Location" required />
      <button type="submit" class="btn btn-secondary">Sign Up</button>
      <p>Already have an account? <a href="student-login.php">Log in here</a></p>
    </form>
  </section>

  <footer class="footer">
    <p>&copy; 2025 GradIntern. All rights reserved.</p>
  </footer>
</body>
</html>
