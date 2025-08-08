<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="home-container">
    <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>