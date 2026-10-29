<?php
ob_start();
require_once __DIR__ . '/../../config.php';
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

$name = trim($payload['name'] ?? '');
$type = trim($payload['type'] ?? '');
$pricePerDay = floatval($payload['price_per_day'] ?? 0);
$location = trim($payload['location'] ?? '');
$fuel = trim($payload['fuel'] ?? '');

// Validate inputs
if (empty($name) || empty($type) || empty($location) || empty($fuel)) {
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
    exit();
}

if ($pricePerDay <= 0) {
    echo json_encode(['success' => false, 'message' => 'Daily rate must be greater than 0.']);
    exit();
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Create vehicles table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    status ENUM('Available', 'Booked', 'Maintenance') DEFAULT 'Available',
    price_per_day DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    engine_capacity VARCHAR(50) DEFAULT NULL,
    color VARCHAR(50) DEFAULT NULL,
    mileage VARCHAR(50) DEFAULT NULL,
    fuel_consumption VARCHAR(50) DEFAULT NULL,
    rating DECIMAL(2,1) DEFAULT 4.5,
    year INT DEFAULT NULL,
    location VARCHAR(100) NOT NULL,
    seats INT DEFAULT NULL,
    transmission VARCHAR(50) DEFAULT NULL,
    fuel VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
@$conn->query($createTableQuery);

// Insert vehicle
$insertQuery = "INSERT INTO vehicles (name, type, price_per_day, location, fuel) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param('sdsss', $name, $type, $pricePerDay, $location, $fuel);

if ($stmt->execute()) {
    $vehicleId = $stmt->insert_id;
    echo json_encode([
        'success' => true,
        'message' => 'Vehicle added successfully!',
        'vehicle_id' => $vehicleId,
        'vehicle_name' => $name,
        'vehicle_type' => $type,
        'price_per_day' => $pricePerDay
    ]);
} else {
    $errorMsg = $conn->error;
    echo json_encode(['success' => false, 'message' => 'Failed to add vehicle: ' . $errorMsg]);
}

$stmt->close();
exit();
?>
