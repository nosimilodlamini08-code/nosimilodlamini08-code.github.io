<?php
// Start output buffering to suppress any error output
ob_start();

// Ensure no output is sent before JSON header
@session_start();

// Suppress errors during require to prevent HTML output
$configFile = __DIR__ . '/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
} else {
    ob_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['success' => false, 'message' => 'Configuration file not found.']);
    exit();
}

// Clear any buffered output from includes
ob_clean();

// Set JSON header after all includes
header('Content-Type: application/json; charset=utf-8');

// Check database connection
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

$payload = $_POST;
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') !== false) {
    $body = file_get_contents('php://input');
    $json = json_decode($body, true);
    if (is_array($json)) {
        $payload = array_merge($payload, $json);
    }
}

$vehicleName = trim($payload['car_model'] ?? '');
$dailyRate = trim($payload['daily_rate'] ?? '0');
$driverName = trim($payload['driver_name'] ?? 'Self-Drive Base');
$paymentMethod = trim($payload['payment_method'] ?? 'Credit/Debit Card');
$transitMethod = trim($payload['transit_method'] ?? 'Company Premise Collection');
$handoverAddress = trim($payload['handover_address'] ?? '');
$totalPayment = floatval(preg_replace('/[^0-9\.]/', '', $payload['total_payment'] ?? $dailyRate));

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$fullName = null;
$vehicleId = null;

// Fetch user's full_name if user is logged in
if ($userId !== null) {
    $userQuery = "SELECT full_name FROM users WHERE id = ? LIMIT 1";
    $userStmt = $conn->prepare($userQuery);
    if ($userStmt) {
        $userStmt->bind_param('i', $userId);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        if ($userResult && $userResult->num_rows === 1) {
            $user = $userResult->fetch_assoc();
            $fullName = $user['full_name'];
        }
        $userStmt->close();
    }
}

if ($vehicleName !== '') {
    $query = "SELECT id FROM vehicles WHERE name = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('s', $vehicleName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $vehicle = $result->fetch_assoc();
            $vehicleId = intval($vehicle['id']);
        }
        $stmt->close();
    }
}

$insertQuery = "INSERT INTO bookings (user_id, vehicle_id, vehicle_name, full_name, total_payment, driver_name, payment_method, transit_method, handover_address, status) VALUES (NULLIF(?, 0), NULLIF(?, 0), ?, ?, ?, ?, ?, ?, ?, 'Confirmed')";
$stmt = $conn->prepare($insertQuery);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: failed to prepare booking insert.']);
    exit();
}

$userIdParam = $userId === null ? 0 : $userId;
$vehicleIdParam = $vehicleId === null ? 0 : $vehicleId;

$stmt->bind_param('iissdssss', $userIdParam, $vehicleIdParam, $vehicleName, $fullName, $totalPayment, $driverName, $paymentMethod, $transitMethod, $handoverAddress);
$executed = $stmt->execute();
$bookingId = $stmt->insert_id;
$stmt->close();

if (!$executed) {
    echo json_encode(['success' => false, 'message' => 'Booking insertion failed.']);
    exit();
}

// Increment live hits counter
$createTableQuery = "CREATE TABLE IF NOT EXISTS admin_stats (stat_key VARCHAR(50) PRIMARY KEY, value INT DEFAULT 0, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
@$conn->query($createTableQuery);

$updateHitsQuery = "INSERT INTO admin_stats (stat_key, value) VALUES ('live_hits_today', 1) ON DUPLICATE KEY UPDATE value = value + 1";
@$conn->query($updateHitsQuery);

echo json_encode(['success' => true, 'booking_id' => $bookingId]);
exit();
