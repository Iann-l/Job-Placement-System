<?php
session_start();
require 'db.php';

if ($_SESSION['role'] != 'employer') {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $employer_id = $_SESSION['user_id'];

    $sql = "INSERT INTO job_postings (title, description, employer_id) VALUES ('$title', '$description', '$employer_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Job posted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Post a New Job</h2>
        <form method="POST" action="post_job.php">
            <label for="title">Job Title:</label>
            <input type="text" name="title" required><br>

            <label for="description">Job Description:</label>
            <textarea name="description" required></textarea><br>

            <input type="submit" value="Post Job" class="btn">
        </form>
    </div>
</body>
</html>
