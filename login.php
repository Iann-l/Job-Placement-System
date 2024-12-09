<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            // Store user information and role in the session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

           
            switch ($_SESSION['role']) {
                case 'graduate':
                    header("Location: graduate_dashboard.php");
                    break;
                case 'employer':
                    header("Location: employer_dashboard.php");
                    break;
                case 'career_advisor':
                    header("Location: advisor_dashboard.php");
                    break;
                default:
                    echo "Invalid role.";
                    exit();
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> 
 
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <input type="submit" name="login" value="Login" class="btn">
            <label>
    <input type="checkbox" name="keep_signed_in"> Keep me signed in
</label>
        </form>
    </div>
    <button onclick="scrollToTop()" id="scrollBtn" class="btn">⬆️ Top</button>

</body>
</html>
