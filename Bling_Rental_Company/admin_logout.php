<?php
require_once 'config.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear admin session variables
unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_failed_attempts']);
unset($_SESSION['admin_lockout_expires']);

// Destroy the session completely
session_destroy();

// Redirect to home page
$redirectUrl = defined('BASE_URL') ? BASE_URL : 'http://localhost/Bling_Rental_Company/';
header("Location: " . $redirectUrl);
exit();
