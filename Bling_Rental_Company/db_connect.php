<?php
// Database configuration setup for local XAMPP environment
$host     = "localhost";
$username = "root";       // Default XAMPP username
$password = "";           // Default XAMPP password is empty
$dbname   = "bling_rental_company"; // Make sure this matches your MySQL database name

// Create connection instance
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection stability - store error without dying
if ($conn->connect_error) {
    $conn_error = "Database Connection Failure: " . $conn->connect_error;
    // Don't die here - let the calling script handle the error
} else {
    // Set charset to utf8mb4 to handle special characters cleanly
    $conn->set_charset("utf8mb4");
}
