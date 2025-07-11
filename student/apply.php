<?php
include "../dbconn.php";
session_start();

// Check login
if (!isset($_SESSION['student_id'])) {
    echo "You must be logged in to apply.";
    exit;
}

$student_id = $_SESSION['student_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $internship_id = intval($_POST['internship_id']);

    // Check if already applied
    $check = $conn->prepare("SELECT id FROM application WHERE student_id = ? AND internship_id = ?");
    $check->bind_param("ii", $student_id, $internship_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<h3>You have already applied for this internship.</h3>";
        echo "<a href='s-dashboard.php' class='btn btn-secondary'>Back to Listings</a>";
        $check->close();
        $conn->close();
        exit;
    }
    
    $check->close();

    // Insert application
    $stmt = $conn->prepare("INSERT INTO application (student_id, internship_id) VALUES (?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }
    $stmt->bind_param("ii", $student_id, $internship_id);

    if ($stmt->execute()) {
        echo "<h2>Application Submitted!</h2>";
        echo "<p>Your application has been submitted successfully.</p>";
        echo "<a href='s-dashboard.php' class='btn btn-secondary'>Back to Listings</a>";
    } else {
        echo "Error submitting the application: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
