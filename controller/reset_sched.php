<?php
session_start();
include("../database/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request");
}

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$userId = (int) $_SESSION['user_id'];

$sql = "
    UPDATE users 
    SET 
        is_in = 0,
        time_in = '00:00',
        time_out = '00:00'
    WHERE id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

if ($stmt->affected_rows >= 0) {
    echo "success";
} else {
    echo "Failed to reset schedule";
}

$stmt->close();
$conn->close();
