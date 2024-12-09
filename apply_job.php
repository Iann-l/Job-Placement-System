<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'graduate') {
    echo "Access denied.";
    exit();
}

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $graduate_id = $_SESSION['user_id'];

    
    $sql = "INSERT INTO applications (job_id, graduate_id, application_status) VALUES ('$job_id', '$graduate_id', 'Pending')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No job selected.";
}

$conn->close();
?>
