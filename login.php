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
        <input type="text" name="email" placeholder="Email" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <button type="submit">Login</button>
    </form>
</body>
</html>


<?php
session_start();
include("./database/database.php");
include("./controller/request.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    return;
}

//Email Pass Check
if (empty($_POST['email']) || empty($_POST['password'])) {
    header("Location: login.php?error=All fields are required");
    exit();
}

$email = trim($_POST['email']);
$pass  = $_POST['password'];


// Get user
use findUser\Request;
$getUser = new Request($conn, $email);
$user = $getUser->getUser();

// If User Don't Exist
if (!$user) {
    header("Location: login.php?error=Invalid email or password");
    exit();
}

// Verify password
if (!password_verify($pass, $user['password'])) {
    header("Location: login.php?error=Invalid email or password");
    exit();
}

// Login success
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['role'] = $user['role'];  

if($_SESSION['role'] == 'admin'){
    header("Location: admin/dashboard.php");
    exit;
}

header("Location: pages/user-dashboard.php");
exit();


?>