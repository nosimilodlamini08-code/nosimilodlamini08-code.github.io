<?php
//======================================================================
// SYSTEM CORE CONFIGURATION PROFILE
//======================================================================

// 1. Initialize Global Session Tracking if not already declared
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Set App Environment & Error Handlers (Set to 0 in live production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 3. System Location and Business Identity Settings
define('APP_NAME', 'Bling Rental Company');
define('APP_CURRENCY', 'E');             // Emalangeni local system denomination
define('APP_LOCATION', 'Mbabane, Eswatini');

// 4. Absolute Path Configuration Mapping
define('BASE_URL', 'http://localhost/Bling_Rental_Company/');

// 5. Autoload Database Link Component
// This automatically hooks up your database connection whenever config.php is loaded
require_once __DIR__ . '/db_connect.php';
