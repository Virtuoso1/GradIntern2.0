<?php
session_start();
include('../dbconn.php'); 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Internship ID is missing or invalid.";
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['student_id'], $_POST['internship_id'])) {
    $status = '';
    if ($_POST['action'] === 'accept') {
        $status = 'Accepted';
    } elseif ($_POST['action'] === 'reject') {
        $status = 'Rejected';
    }

    if ($status !== '') {
        $stmt = $conn->prepare("UPDATE application SET application_status = ? WHERE student_id = ? AND internship_id = ?");
        $stmt->bind_param("sii", $status, $_POST['student_id'], $_POST['internship_id']);
        $stmt->execute();
        $stmt->close();
    }
}

$internship_id = intval($_GET['id']);

$internship_stmt = $conn->prepare("SELECT title FROM internship WHERE id = ?");
$internship_stmt->bind_param("i", $internship_id);
$internship_stmt->execute();
$internship_result = $internship_stmt->get_result();

if ($internship_result->num_rows === 0) {
    echo "Internship not found.";
    exit;
}

$internship = $internship_result->fetch_assoc();

$applicants_stmt = $conn->prepare("
    SELECT student.id, student.s_name, student.email, student.phone_no, application.applied_at, application.application_status 
    FROM application
    INNER JOIN student ON application.student_id = student.id
    WHERE application.internship_id = ?
    ORDER BY application.applied_at, application.application_status DESC
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
                <th>Status</th>
                <th>Action</th>

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
                
        <td><?= htmlspecialchars($row['application_status'] ?? 'pending') ?></td>
        <td>
            <form method="post" style="display:inline;">
                <input type="hidden" name="student_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="internship_id" value="<?= $internship_id ?>">
                <button type="submit" name="action" value="accept" onclick="return confirm('Accept this application?')">Accept</button>
            </form>
            <form method="post" style="display:inline;">
                <input type="hidden" name="student_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="internship_id" value="<?= $internship_id ?>">
                <button type="submit" name="action" value="reject" onclick="return confirm('Reject this application?')">Reject</button>
            </form>
        </td>

</tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center;">No applicants found for this internship.</p>
<?php endif; ?>

</body>
</html>
