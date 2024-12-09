<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'graduate') {
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM job_postings WHERE status = 'open'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduate Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the stylesheet -->
</head>
<body>
    <div class="container">
        <h2>Available Jobs</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($job = $result->fetch_assoc()) {
                echo "<div class='job-item'>";
                echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($job['description']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No jobs available at the moment.</p>";
        }
        ?>
    </div>
</body>
</html>
