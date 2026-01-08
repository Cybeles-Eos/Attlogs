<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make User</title>
</head>
<body>
    <form method="POST" action="signin.php">
        <input type="text" name="name" placeholder="Full Name" required autocomplete="off">
        <input type="email" name="email" placeholder="Email" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <input type="password" name="conf_password" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>


<?php
include("./database/database.php");
include("./controller/insert.php");

use newUser\InsertNewUser;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// POST only
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}

// Required fields
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['conf_password'])) {
    // echo "<script>alert('All fields are required');</script>";
    header("Location: signup.php");
    exit();
}

$name  = trim($_POST['name']);
$email = trim($_POST['email']);
$pass  = $_POST['password'];
$conf  = $_POST['conf_password'];

// Length check
if (strlen($pass) < 7) {
    echo "<script>alert('Password must be at least 7 characters');</script>";
    exit();
}

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email address');</script>";
    exit();
}

// Password match
if ($pass !== $conf) {
    echo "<script>alert('Passwords do not match');</script>";
    exit();
}

// Check if email exists
$checkSql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Email already registered');</script>";
    exit();
}

$stmt->close();

// Hash password
$hash = password_hash($pass, PASSWORD_DEFAULT);

// Insert user
$insert = new InsertNewUser($conn, $name, $email, $hash);
$insert->insert();

echo "<script>
    alert('User created successfully');
    window.location.href = 'login.php';
</script>";

mysqli_close($conn);
exit();


?>