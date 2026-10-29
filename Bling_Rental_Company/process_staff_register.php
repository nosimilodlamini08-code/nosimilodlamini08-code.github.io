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

$fullName = trim($payload['full_name'] ?? '');
$email = trim($payload['email'] ?? '');
$licenseNumber = trim($payload['license_number'] ?? '');
$role = trim($payload['role'] ?? 'Chauffeur Driver');
$phone = trim($payload['phone'] ?? '');
$address = trim($payload['address'] ?? '');
$experienceYears = intval($payload['experience_years'] ?? 0);

// Validate inputs
if (empty($fullName) || empty($email) || empty($licenseNumber)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit();
}

if (!isset($conn)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Create staff table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    license_number VARCHAR(50) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'Chauffeur Driver',
    phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    experience_years INT DEFAULT 0,
    profile_image VARCHAR(255) DEFAULT NULL,
    rating DECIMAL(3,1) DEFAULT 4.5,
    reviews_count INT DEFAULT 0,
    age INT DEFAULT NULL,
    gender VARCHAR(20) DEFAULT 'Male',
    license_class VARCHAR(10) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
@$conn->query($createTableQuery);

// Add new columns if they don't exist (for existing tables)
$alterQueries = [
    "ALTER TABLE staff ADD COLUMN phone VARCHAR(20) DEFAULT NULL",
    "ALTER TABLE staff ADD COLUMN address TEXT DEFAULT NULL",
    "ALTER TABLE staff ADD COLUMN experience_years INT DEFAULT 0"
];
foreach ($alterQueries as $alterQuery) {
    @$conn->query($alterQuery);
}

// Insert staff member
$insertQuery = "INSERT INTO staff (full_name, email, license_number, role, phone, address, experience_years) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertQuery);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param('sssssis', $fullName, $email, $licenseNumber, $role, $phone, $address, $experienceYears);

if ($stmt->execute()) {
    $staffId = $stmt->insert_id;
    echo json_encode([
        'success' => true,
        'message' => 'Employee registered successfully!',
        'staff_id' => $staffId,
        'staff_name' => $fullName,
        'staff_email' => $email,
        'staff_license' => $licenseNumber,
        'staff_role' => $role
    ]);
} else {
    $errorMsg = $conn->error;
    if (strpos($errorMsg, 'Duplicate entry') !== false) {
        echo json_encode(['success' => false, 'message' => 'Email or License Number already registered.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register employee: ' . $errorMsg]);
    }
}

$stmt->close();
exit();
?>
