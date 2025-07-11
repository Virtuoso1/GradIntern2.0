<?php
session_start();
include '.../dbconn.php'; 


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['recruiter_id'])) {
    $listing_id = $_POST['listing_id'];
    $recruiter_id = $_SESSION['recruiter_id'];

    $stmt = $conn->prepare("DELETE FROM internship WHERE id = ? AND recruiter_id = ?");
    $stmt->bind_param("ii", $listing_id, $recruiter_id);

    if ($stmt->execute()) {
        header("Location: recruiterdashboard.php");
        exit();
    } else {
        echo "Error deleting listing.";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: recruiterlogin.php");
    exit();
}
?>