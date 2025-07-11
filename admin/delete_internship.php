<?php
session_start();
require "../dbconn.php";

// Protect route
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['internship_id'])) {
    $internship_id = intval($_POST['internship_id']);

    // First, delete any related applications
    $conn->query("DELETE FROM application WHERE internship_id = $internship_id");

    // Then delete the internship
    $stmt = $conn->prepare("DELETE FROM internship WHERE id = ?");
    $stmt->bind_param("i", $internship_id);

    if ($stmt->execute()) {
        header("Location: internships.php?deleted=1");
        exit();
    } else {
        echo "Error deleting listing: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
