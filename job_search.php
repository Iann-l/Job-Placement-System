<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Search and Apply for Jobs</h2>
        <?php
        session_start();
        require 'db.php';

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'graduate') {
            header("Location: login.php");
            exit();
        }

        $sql = "SELECT * FROM job_postings WHERE status = 'open'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($job = $result->fetch_assoc()) {
                echo "<div class='job-item'>";
                echo "<h3>" . htmlspecialchars($job['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($job['description']) . "</p>";
                echo "<form method='POST' action='job_search.php'>";
                echo "<input type='hidden' name='job_id' value='" . $job['job_id'] . "'>";
                echo "<input type='submit' name='apply' value='Apply' class='btn'>";
                echo "</form>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No jobs available at the moment.</p>";
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply'])) {
            $job_id = $conn->real_escape_string($_POST['job_id']);
            $graduate_id = $_SESSION['user_id'];

            $check_sql = "SELECT * FROM applications WHERE job_id = '$job_id' AND graduate_id = '$graduate_id'";
            $check_result = $conn->query($check_sql);

            if ($check_result && $check_result->num_rows > 0) {
                echo "<p>You have already applied for this job.</p>";
            } else {
                $insert_sql = "INSERT INTO applications (job_id, graduate_id, status) VALUES ('$job_id', '$graduate_id', 'pending')";
                if ($conn->query($insert_sql) === TRUE) {
                    echo "<p>Application submitted successfully!</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
