<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    echo "Access denied. Only employers can access this page.";
    exit();
}
?>




<?php

require 'db.php';

if ($_SESSION['role'] != 'employer') {
    echo "Access denied.";
    exit();
}

$employer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM job_postings WHERE employer_id = '$employer_id'";
$result = $conn->query($sql);

echo "<div class='manage-container'>";
echo "<h2>Your Job Postings</h2>";
if ($result->num_rows > 0) {
    while ($job = $result->fetch_assoc()) {
        echo "<div class='job-item'>";
        echo "<h3>" . $job['title'] . "</h3>";
        echo "<p>" . $job['description'] . "</p>";
        echo "<a href='edit_job.php?job_id=" . $job['job_id'] . "' class='btn'>Edit</a>";
        echo "<a href='delete_job.php?job_id=" . $job['job_id'] . "' class='btn delete-btn'>Delete</a>";
        echo "</div><hr>";
    }
} else {
    echo "<p>You have not posted any jobs yet.</p>";
}
echo "</div>";
?>

