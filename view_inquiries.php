<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'career_advisor') {
    header("Location: login.php");
    exit();
}


$sql = "SELECT * FROM inquiries";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Inquiries</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Graduate Inquiries</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($inquiry = $result->fetch_assoc()) {
                echo "<div class='item'>";
                echo "<p><strong>Graduate ID:</strong> " . htmlspecialchars($inquiry['graduate_id']) . "</p>";
                echo "<p><strong>Question:</strong> " . htmlspecialchars($inquiry['question']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($inquiry['inquiry_date']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No inquiries found.</p>";
        }
        ?>
    </div>
</body>
</html>
