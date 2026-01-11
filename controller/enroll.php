<?php
session_start();
include("../database/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request");
}

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$userId = intval($_POST['user_id']);

// Update is_in to 1
$sql = "UPDATE users SET is_enrolled = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "success";
} else {
    echo "Already enroll or user not found";
}

$stmt->close();
$conn->close();
