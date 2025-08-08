<?php
session_start();
require_once "db.php";
require_once "User.php";

$db = (new Database())->getConnection();
$user = new User($db);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST['username_or_email'];
    $password = $_POST['password'];

    $loggedInUser = $user->login($username_or_email, $password);
    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;
        header("Location: home.php");
        exit;
    } else {
        $message = "Invalid login credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Login</h2>
    <form method="post">
        <input type="text" name="username_or_email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p><?php echo $message; ?></p>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>
</body>
</html>