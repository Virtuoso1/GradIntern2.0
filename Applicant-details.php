<?php
// Start session and include DB connection
session_start();
include('dbconn.php'); // replace with your database connection script

// Check if internship_id is passed
if (!isset($_GET['internship_id'])) {
    echo "Internship ID is missing.";
    exit;
}

$internship_id = intval($_GET['internship_id']);

// Fetch internship details
$internship_query = $conn->prepare("SELECT title FROM internships WHERE id = ?");
$internship_query->bind_param("i", $internship_id);
$internship_query->execute();
$internship_result = $internship_query->get_result();

if ($internship_result->num_rows === 0) {
    echo "Internship not found.";
    exit;
}

$internship = $internship_result->fetch_assoc();

// Fetch applicants
$applicants_query = $conn->prepare("
    SELECT users.id, users.name, users.email, users.phone, applications.applied_at 
    FROM applications 
    INNER JOIN users ON applications.user_id = users.id 
    WHERE applications.internship_id = ?
    ORDER BY applications.applied_at DESC
");
$applicants_query->bind_param("i", $internship_id);
$applicants_query->execute();
$applicants_result = $applicants_query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applicants for <?= htmlspecialchars($internship['title']) ?></title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Applicants for: <?= htmlspecialchars($internship['title']) ?></h2>

<?php if ($applicants_result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Applied At</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $count = 1;
        while ($row = $applicants_result->fetch_assoc()): ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['applied_at']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <p style="text-align: center;">No applicants found for this internship.</p>
<?php endif; ?>

</body>
</html>
