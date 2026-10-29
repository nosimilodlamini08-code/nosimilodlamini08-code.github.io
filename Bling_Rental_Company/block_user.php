<?php
require_once 'config.php';
require_once 'admin_check.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$payload = $_POST;

if (stripos($contentType, 'application/json') !== false) {
    $body = file_get_contents('php://input');
    $json = json_decode($body, true);
    if (is_array($json)) {
        $payload = array_merge($payload, $json);
    }
}

$userId = intval($payload['user_id'] ?? 0);

if ($userId === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
    exit();
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

$stmt = $conn->prepare("UPDATE users SET is_blocked = 1 WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User has been permanently blocked.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to block user.']);
}

$stmt->close();
exit();
