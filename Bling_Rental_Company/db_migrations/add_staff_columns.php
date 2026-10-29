<?php
// Database migration to add missing columns to staff table
require_once __DIR__ . '/../config.php';

echo "Starting staff table migration...\n";

// Check if staff table exists
$checkTable = "SHOW TABLES LIKE 'staff'";
$result = $conn->query($checkTable);

if ($result->num_rows == 0) {
    echo "Staff table does not exist. It will be created when first staff member is added.\n";
    exit;
}

// Get existing columns
$columnsQuery = "SHOW COLUMNS FROM staff";
$columnsResult = $conn->query($columnsQuery);
$existingColumns = [];
while ($row = $columnsResult->fetch_assoc()) {
    $existingColumns[] = $row['Field'];
}

// Columns to add
$columnsToAdd = [
    'phone' => "ALTER TABLE staff ADD COLUMN phone VARCHAR(20) DEFAULT NULL",
    'address' => "ALTER TABLE staff ADD COLUMN address TEXT DEFAULT NULL",
    'experience_years' => "ALTER TABLE staff ADD COLUMN experience_years INT DEFAULT 0"
];

foreach ($columnsToAdd as $columnName => $alterSQL) {
    if (!in_array($columnName, $existingColumns)) {
        echo "Adding column: $columnName...\n";
        if ($conn->query($alterSQL)) {
            echo "✓ Column '$columnName' added successfully.\n";
        } else {
            echo "✗ Error adding column '$columnName': " . $conn->error . "\n";
        }
    } else {
        echo "Column '$columnName' already exists. Skipping.\n";
    }
}

echo "\nMigration completed.\n";
?>
