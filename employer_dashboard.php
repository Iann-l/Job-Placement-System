<?php
session_start();
require 'db.php';

// Ensure the user is logged in and is an employer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    header("Location: login.php");
    exit();
}

// Handle job posting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_job'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $employer_id = $_SESSION['user_id'];

    $sql = "INSERT INTO job_postings (title, description, employer_id, status) 
            VALUES ('$title', '$description', '$employer_id', 'open')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Job posted successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Handle job deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_job'])) {
    $job_id = $conn->real_escape_string($_POST['job_id']);

    $sql = "DELETE FROM job_postings WHERE job_id = '$job_id' AND employer_id = '" . $_SESSION['user_id'] . "'";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Job deleted successfully!</p>";
        header("Refresh:0"); // Refresh the page to show updated jobs
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Employer Dashboard</h2>

        
        <h3>Post a Job</h3>
        <form method="post" action="employer_dashboard.php">
            <label>Job Title:</label>
            <input type="text" name="title" required><br>
            <label>Description:</label>
            <textarea name="description" required></textarea><br>
            <input type="submit" name="post_job" value="Post Job" class="btn">
        </form>

        
        <h3>Your Posted Jobs</h3>
        <?php
        
        $employer_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM job_postings WHERE employer_id = '$employer_id'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($job = $result->fetch_assoc()) {
                echo "<div class='job-item'>";
                echo "<h4>" . htmlspecialchars($job['title']) . "</h4>";
                echo "<p>" . htmlspecialchars($job['description']) . "</p>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($job['status']) . "</p>";
                echo "<form method='post' action='employer_dashboard.php'>";
                echo "<input type='hidden' name='job_id' value='" . $job['job_id'] . "'>";
                echo "<input type='submit' name='delete_job' value='Delete Job' class='btn btn-danger'>";
                echo "</form>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No jobs posted yet.</p>";
        }
        ?>
    </div>
</body>
</html>
