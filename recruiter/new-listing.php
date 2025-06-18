<!DOCTYPE html>
<html>
<head>
    <title>Create Internship</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
  <div class="container">
    <h2>Create New Internship</h2>
    <form method="post" action="/recruiter/create-listing/">
      <input type="hidden" name="csrfmiddlewaretoken" value="FAKE_CSRF_TOKEN_PLACEHOLDER">

      <p>
        <label for="id_title">Title:</label>
        <input type="text" name="title" id="id_title" required>
      </p>
      <p>
        <label for="id_internship_description">Description:</label>
        <textarea name="internship_description" id="id_internship_description" required></textarea>
      </p>
      <p>
        <label for="id_stipend">Stipend:</label>
        <input type="number" name="stipend" id="id_stipend" step="0.01" required>
      </p>
      <p>
        <label for="id_location">Location:</label>
        <input type="text" name="location" id="id_location" required>
      </p>
      <p>
        <label for="id_skills_required">Skills Required:</label>
        <textarea name="skills_required" id="id_skills_required" required></textarea>
      </p>

      <button type="submit" class="btn">Post Internship</button>
    </form>
  </div>
</body>
</html>
