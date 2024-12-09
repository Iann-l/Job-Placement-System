<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Tracking</title>
    <link rel="stylesheet" href="style.css"> !-- Link to the stylesheet -->
</head>
<body>
    <div class="container">
        <h2>Jobs You've Applied For</h2>
        <?php
        session_start();
        require 'db.php';

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'graduate') {
            header("Location: login.php");
            exit();
        }

        $graduate_id = $_SESSION['user_id'];
        $sql = "SELECT j.title, j.description, a.application_date, a.status 
                FROM applications a 
                JOIN job_postings j ON a.job_id = j.job_id 
                WHERE a.graduate_id = '$graduate_id' AND j.status = 'open'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='job-item'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                echo "<p><strong>Application Date:</strong> " . htmlspecialchars($row['application_date']) . "</p>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($row['status']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>You have not applied for any jobs yet.</p>";
        }
        ?>
    </div>
</body>
</html>
