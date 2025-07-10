<?php
// Start session 
session_start();
include('dbconn.php'); //DB connection

// Check if internship_id is passed
if (!isset($_GET['internship_id']) || !is_numeric($_GET['internship_id'])) {
    echo "Internship ID is missing or invalid.";
    exit;
}

$internship_id = intval($_GET['internship_id']);

// Fetch internship details
$internship_stmt = $conn->prepare("SELECT title FROM internship WHERE id = ?");
$internship_stmt->bind_param("i", $internship_id);
$internship_stmt->execute();
$internship_result = $internship_stmt->get_result();

if ($internship_result->num_rows === 0) {
    echo "Internship not found.";
    exit;
}

$internship = $internship_result->fetch_assoc();

// Fetch student applicants
$applicants_stmt = $conn->prepare("
    SELECT student.id, student.s_name, student.email, student.phone_no, application.applied_at 
    FROM application
    INNER JOIN student ON application.student_id = student.id
    WHERE application.internship_id = ?
    ORDER BY application.applied_at DESC
");
$applicants_stmt->bind_param("i", $internship_id);
$applicants_stmt->execute();
$applicants_result = $applicants_stmt->get_result();
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
    <p style="text-align:center;"><?= $applicants_result->num_rows ?> applicant(s) found.</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
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
                    <td><?= htmlspecialchars($row['s_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone_no']) ?></td>
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
