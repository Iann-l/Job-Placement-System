<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'career_advisor') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Office</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Career Office</h2>
        <p>Here you can respond to graduate inquiries and provide career guidance resources.</p>

       
        <h3>Graduate Inquiries</h3>
        <?php
        $sql = "SELECT * FROM inquiries"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($inquiry = $result->fetch_assoc()) {
                echo "<div class='inquiry-item'>";
                echo "<p><strong>From:</strong> " . $inquiry['graduate_name'] . "</p>";
                echo "<p><strong>Question:</strong> " . $inquiry['question'] . "</p>";
                echo "<a href='respond_inquiry.php?inquiry_id=" . $inquiry['id'] . "' class='btn'>Respond</a>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No inquiries from graduates at this time.</p>";
        }
        ?>

       
        <h3>Career Resources</h3>
        <p>Share articles, tips, and guides for graduates.</p>
        <a href="post_resources.php" class="btn">Add New Resource</a>
    </div>
</body>
</html>
