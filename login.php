<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Book</title>
</head>
<body>
    <h1>Login Your Account</h1>
    <a href="signin.php">create account</a>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <button type="submit">Login</button>
    </form>
</body>
</html>


<?php
session_start();
include("./database/database.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    return;
}

if (empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: login.php?error=All fields are required");
    exit();
}

$email = trim($_POST['email']);
$pass  = $_POST['password'];

// Get user
$sql = "SELECT id, name, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: login.php?error=Invalid email or password");
    exit();
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($pass, $user['password'])) {
    header("Location: login.php?error=Invalid email or password");
    exit();
}

// Login success
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];

header("Location: pages/user-dashboard.php");
exit();


?>