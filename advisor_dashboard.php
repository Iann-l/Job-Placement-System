<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'career_advisor') {
    echo "Access denied.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advisor Dashboard</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Welcome, Career Advisor <?php echo $_SESSION['name']; ?></h2>
        <p>This is your dashboard where you can manage inquiries, provide guidance, and view appointments.</p>

        
        <div class="dashboard-links">
            <a href="career_office.php" class="btn">Career Office</a>
            <a href="view_inquiries.php" class="btn">View Graduate Inquiries</a>
            <a href="manage_appointments.php" class="btn">Manage Appointments</a>
            <a href="post_resources.php" class="btn">Post Resources</a>
        </div>
    </div>
</body>
</html>
