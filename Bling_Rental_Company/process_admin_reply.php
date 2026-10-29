<?php
ob_start();
require_once 'config.php';
ob_clean();

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

$feedbackId = intval($payload['feedback_id'] ?? 0);
$adminReply = $payload['admin_response'] ?? null;
$clientEmail = $payload['client_email'] ?? null;

if ($feedbackId === 0 || !$adminReply || !$clientEmail) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit();
}

if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit();
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Sanitize inputs
$adminReply = htmlspecialchars(trim($adminReply), ENT_QUOTES, 'UTF-8');

// Update feedback with admin reply
$stmt = $conn->prepare("UPDATE feedback SET admin_response = ? WHERE id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param('si', $adminReply, $feedbackId);

if ($stmt->execute()) {
    // Send email to client
    $subject = "Re: Your Feedback to Bling Rental Company";
    $message = "Hello,\n\n";
    $message .= "Thank you for your feedback to Bling Rental Company.\n\n";
    $message .= "Admin Response:\n";
    $message .= "================\n";
    $message .= $adminReply . "\n\n";
    $message .= "Best regards,\n";
    $message .= "Bling Rental Company Admin Team\n";
    $message .= "www.blingrental.com\n";

    $headers = "From: admin@blingrental.sz\r\n";
    $headers .= "Reply-To: admin@blingrental.sz\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($clientEmail, $subject, $message, $headers)) {
        echo json_encode([
            'success' => true,
            'message' => 'Reply sent successfully to ' . $clientEmail
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database updated but failed to send email.'
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update feedback.']);
}

$stmt->close();
exit();
