<?php
include('dbconn.php');
session_start();

// Fetch all internships
$query = "SELECT * FROM internship ORDER BY posted_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        body {
            background-color: #f0f6ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #003366;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 950px;
            margin: 50px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #004080;
            margin-bottom: 40px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #cce0ff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 51, 102, 0.1);
        }

        .card h2 {
            margin: 0;
            color: #004080;
        }

        .card p {
            margin: 8px 0;
        }

        .view-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: #005cbf;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .view-btn:hover {
            background-color: #004999;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Available Internship Listings</h1>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="card">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
            <p><strong>Stipend:</strong> Ksh <?php echo htmlspecialchars($row['stipend']); ?></p>
            <p><strong>Skills Required:</strong> <?php echo htmlspecialchars($row['skills_required']); ?></p>
            <p><strong>Description:</strong> <?php echo substr(htmlspecialchars($row['internship_description']), 0, 100) . '...'; ?></p>
            <a href="student-listing-details.php?id=<?php echo $row['id']; ?>" class="view-btn">View Details</a>
        </div>
    <?php } ?>
</div>

</body>
</html>
