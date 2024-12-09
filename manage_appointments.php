<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'career_advisor') {
    header("Location: login.php");
    exit();
}


$advisor_id = $_SESSION['user_id'];
$sql = "SELECT * FROM appointments WHERE advisor_id = '$advisor_id'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <h2>Manage Appointments</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($appointment = $result->fetch_assoc()) {
                echo "<div class='item'>";
                echo "<p><strong>Graduate ID:</strong> " . htmlspecialchars($appointment['graduate_id']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($appointment['appointment_date']) . "</p>";
                echo "<p><strong>Status:</strong> " . htmlspecialchars($appointment['status']) . "</p>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>No appointments scheduled yet.</p>";
        }
        ?>
    </div>
</body>
</html>




