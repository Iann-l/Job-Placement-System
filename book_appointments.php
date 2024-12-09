<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css"><
</head>
<body>
    <div class="container">
        <h2>Book an Appointment</h2>
        <form method="POST" action="book_appointment.php">
            <label>Advisor ID:</label><input type="number" name="advisor_id" required><br>
            <label>Appointment Date:</label><input type="datetime-local" name="appointment_date" required><br>
            <input type="submit" name="book_appointment" value="Book Appointment">
        </form>
        <?php
        session_start();
        require 'db.php';

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'graduate') {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_appointment'])) {
            $advisor_id = $conn->real_escape_string($_POST['advisor_id']);
            $graduate_id = $_SESSION['user_id'];
            $appointment_date = $conn->real_escape_string($_POST['appointment_date']);

            $sql = "INSERT INTO appointments (advisor_id, graduate_id, appointment_date, status) 
                    VALUES ('$advisor_id', '$graduate_id', '$appointment_date', 'pending')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Appointment booked successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
