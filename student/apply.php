<?php
$conn = new mysqli("127.0.0.1:3307", "root", "1604", "grad");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (!isset($_SESSION['student_id'])) {
    echo "You must be logged in to apply.";
    exit;
}

$student_id = $_SESSION['student_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $internship_id = intval($_POST['internship_id']);
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $student_email = $conn->real_escape_string($_POST['student_email']);
    $cover_letter = $conn->real_escape_string($_POST['cover_letter']);

    $sql = "INSERT INTO application (internship_id, name, email, cover_letter) VALUES ($internship_id, '$student_name', '$student_email', '$cover_letter')";

    if ($conn->query($sql) === TRUE) {
        echo "<h2>Application Submitted!</h2>";
        echo "<p>Thank you, <strong>$student_name</strong>. Your application for the internship has been submitted successfully.</p>";
        echo "<a href='student-listings.php' class='btn btn-secondary'>Back to Listings</a>";
    } else {
        echo "Error: " .$conn->error;
    }

} else {
    echo "Invalid request.";
}
$conn->close();
?>

 
