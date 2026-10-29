<?php
// Open master session architecture state array access
session_start();
// Load app config to get BASE_URL
if (!defined('BASE_URL')) {
    $cfg = __DIR__ . '/config.php';
    if (file_exists($cfg)) require_once $cfg;
}

// Flush all variables and remove session tokens from server memory
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy structural host container completely
session_destroy();

// Redirect back to login screen index node
header("Location: " . (defined('BASE_URL') ? BASE_URL . 'login.php?logout=success' : '/Bling_Rental_Company/login.php?logout=success'));
exit;
