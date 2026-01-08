<?php
session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }

    //Get User Data 
    $nameId = htmlspecialchars($_SESSION['user_id']);
    $name = htmlspecialchars($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
</head>
<body>
    <h1><?= $nameId ?>World <?= $name ?></h1>
    <a href="../logout.php">Logout</a>
</body>
</html>