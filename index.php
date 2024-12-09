<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Placement Platform</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to the Job Placement Platform</h1>
            <p>Your one-stop solution for connecting graduates with employers.</p>
        </header>

        <main>
            <h2>Hello, <?php echo $_SESSION['name']; ?>!</h2>
            <?php if ($_SESSION['role'] == 'graduate'): ?>
                <p>As a Graduate, you can search for jobs and track your applications.</p>
                <a href="job_search.php" class="btn">Job Search</a>
                <a href="application_tracking.php" class="btn">Application Tracking</a>
            <?php elseif ($_SESSION['role'] == 'employer'): ?>
                <p>As an Employer, you can post new job openings.</p>
                <a href="post_job.php" class="btn">Post a Job</a>
                <a href="manage_jobs.php" class="btn">Manage Job Postings</a>
            <?php elseif ($_SESSION['role'] == 'career_advisor'): ?>
                <p>As a Career Advisor, you can offer guidance to graduates.</p>
                <a href="career_guidance.php" class="btn">Career Guidance</a>
            <?php endif; ?>
        </main>

        <footer>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </footer>
    </div>
</body>
</html>
