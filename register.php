<?php
session_start();
require_once "db.php";
require_once "User.php";

$db = (new Database())->getConnection();
$user = new User($db);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        if ($user->register($full_name, $username, $email, $password)) {
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $message = "Error: Email already exists or registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <form method="post">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
    <p><?php echo $message; ?></p>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>