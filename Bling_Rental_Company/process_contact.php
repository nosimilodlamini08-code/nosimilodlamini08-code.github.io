<?php
// Ensure no output before headers
ob_start();

require_once 'config.php';

// Clear any buffered output before setting headers
ob_clean();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Get form data
$clientName = $_POST['client_name'] ?? null;
$clientEmail = $_POST['client_email'] ?? null;
$clientMessage = $_POST['client_message'] ?? null;

// Validate inputs
if (!$clientName || !$clientEmail || !$clientMessage) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Validate email format
if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit();
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Sanitize inputs
$clientName = htmlspecialchars(trim($clientName), ENT_QUOTES, 'UTF-8');
$clientEmail = htmlspecialchars(trim($clientEmail), ENT_QUOTES, 'UTF-8');
$clientMessage = htmlspecialchars(trim($clientMessage), ENT_QUOTES, 'UTF-8');

// Check if feedback table exists and has required columns
$checkTableQuery = "SHOW COLUMNS FROM feedback LIKE 'client_name'";
$checkResult = @$conn->query($checkTableQuery);

if (!$checkResult || $checkResult->num_rows === 0) {
    // Add the missing columns if they don't exist
    @$conn->query("ALTER TABLE feedback ADD COLUMN client_name VARCHAR(100) DEFAULT 'Anonymous' AFTER id");
    @$conn->query("ALTER TABLE feedback ADD COLUMN client_email VARCHAR(150) DEFAULT NULL AFTER client_name");
}

// Insert feedback into database
$stmt = $conn->prepare("INSERT INTO feedback (client_name, client_email, message) VALUES (?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param('sss', $clientName, $clientEmail, $clientMessage);

if ($stmt->execute()) {
    $feedbackId = $stmt->insert_id;
    echo json_encode([
        'success' => true,
        'message' => 'Feedback successfully submitted to admin panel!',
        'feedback_id' => $feedbackId
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit feedback.']);
}

$stmt->close();
exit();
