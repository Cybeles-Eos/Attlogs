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

$sql = "
    UPDATE users
    SET
        is_in = 0,
        time_in = '00:00',
        time_out = '00:00'
";

$stmt = $conn->prepare($sql);
$stmt->execute();

echo "success";

$stmt->close();
$conn->close();
