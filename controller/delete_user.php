<?php
session_start();
include("../database/database.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request");
}

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

// OPTIONAL: allow ONLY admin to reset everyone
// You must have role saved in session OR fetch from DB.
// If you have $_SESSION['role']:
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Forbidden");
}

// Validate user_id from POST
if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    exit("Invalid user ID");
}
$userId = (int) $_POST['user_id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

echo "success";

$stmt->close();
$conn->close();
