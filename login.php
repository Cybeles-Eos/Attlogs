<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Book</title>
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/jquery-ui.min.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>

</head>
<body class="d-flex align-items-center py-4" style="height: 100vh;">
    <main class="form-signin m-auto" style="width: 400px;"> 
        <form method="POST" action="login.php"> 
            <!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">  -->
            <h1 class="h4 mb-3 fw-normal">Sign In Your Account</h1> 
            <div class="form-floating mb-2"> 
                <input type="text" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required autocomplete="off"> 
                <label for="floatingInput">Email address</label> 
            </div> 
            <div class="form-floating mb-2"> 
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="new-password"> 
                <label for="floatingPassword">Password</label> 
            </div> 
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button> 
            <div class="form-check p-0 pb-4 text-start mt-3 mb-5"> 
                <p >Don't have account?  <a href="signin.php">Create now</a></p>
            </div> 
            <p class="mt-5 mb-3 text-body-secondary text-center">Team Daniii ♥</p> 
        </form> 
    </main>
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
$_SESSION['is_in'] = $user['is_in'];  
$_SESSION['is_enrolled'] = $user['is_enrolled'];  

if($_SESSION['role'] == 'admin'){
    header("Location: admin/dashboard.php");
    exit;
}

header("Location: pages/user-dashboard.php");
exit();


?>