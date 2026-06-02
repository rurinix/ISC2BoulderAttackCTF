<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
    ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') {
    http_response_code(403);
    exit();
}

require '/var/www/db_connect.php';

$user_name = trim($_POST['user_name'] ?? '');

if (!preg_match('/^[a-zA-Z0-9\-_]+$/', $user_name)) {
    echo json_encode(['exists' => false]);
    exit();
}

$stmt = $conn->prepare("SELECT user_name FROM players WHERE user_name = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$stmt->store_result();

echo json_encode(['exists' => $stmt->num_rows > 0]);

$stmt->close();
$conn->close();