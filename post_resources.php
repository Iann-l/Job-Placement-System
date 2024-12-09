<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Career Resource</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Post a New Career Resource</h2>
        <form method="POST" action="post_resources.php">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br>

            <label for="content">Content:</label>
            <textarea name="content" required></textarea><br>

            <input type="submit" value="Post Resource" class="btn">
        </form>
    </div>
</body>
</html>


<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'career_advisor') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO resources (title, content, created_by) VALUES ('$title', '$content', '$created_by')";
    if ($conn->query($sql) === TRUE) {
        echo "Resource posted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>









