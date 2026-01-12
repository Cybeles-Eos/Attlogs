<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/jquery-ui.min.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
</head>
<body class="d-flex align-items-center py-4" style="height: 100vh;">
    <main class="form-signin m-auto" style="width: 400px;"> 
        <form method="POST" action="signin.php"> 
            <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">  -->
            <h1 class="h4 mb-3 fw-normal">Crate Your Account</h1> 
            <div class="form-floating mb-2"> 
                <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Juan Dela Cruz" required autocomplete="off"> 
                <label for="floatingInput">Full Name</label> 
            </div> 
            <div class="form-floating mb-2"> 
                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required autocomplete="off"> 
                <label for="floatingInput">Email address</label> 
            </div> 
            <div class="form-floating mb-2"> 
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="new-password"> 
                <label for="floatingPassword">Password</label> 
            </div> 
            <div class="form-floating mb-2"> 
                <input type="password" name="conf_password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="new-password"> 
                <label for="floatingPassword">Confirm Password</label> 
            </div> 
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button> 
            <div class="form-check p-0 text-start mt-3 mb-5"> 
                <p>Already have account?  <a href="login.php">Login now</a></p>
            </div> 
            <p class="mt-5 mb-3 text-body-secondary text-center">Team Daniii ♥</p> 
        </form> 
    </main>
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