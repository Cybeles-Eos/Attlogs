<?php
session_start();
include("../database/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request");
}

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$userId = (int) $_SESSION['user_id']; // trust session, not POST

// Get current time (12-hour format)
date_default_timezone_set('Asia/Manila');
$timeIn = date("h:i A");

// Update is_in AND time_in
$sql = "UPDATE users SET is_in = 1, time_in = ? WHERE id = ? AND is_in = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $timeIn, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "success";
} else {
    echo "Already timed in";
}

$stmt->close();
$conn->close();
