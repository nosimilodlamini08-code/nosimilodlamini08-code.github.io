<?php
require_once 'config.php';

// Ensure database connection is available
if (!isset($conn) || $conn->connect_error) {
    die('Database connection error');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_mode = $_POST['auth_mode'] ?? 'login';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $face_encoding = trim($_POST['face_encoding'] ?? '');

    $lockoutActive = isset($_SESSION['admin_lockout_expires']) && time() < $_SESSION['admin_lockout_expires'];
    if ($lockoutActive) {
        header("Location: admin_gate.php?error=locked");
        exit();
    }

    if ($auth_mode === 'signup') {
        $username = trim($_POST['admin_name'] ?? 'Admin User');
        $hashed_pass = password_hash($password, PASSWORD_BCRYPT);

        $columnCheck = $conn->query("SHOW COLUMNS FROM admins LIKE 'face_encoding'");
        if (!$columnCheck || $columnCheck->num_rows === 0) {
            $conn->query("ALTER TABLE admins ADD COLUMN face_encoding LONGTEXT DEFAULT NULL AFTER password");
        }

        $stmt = $conn->prepare("INSERT INTO admins (username, email, password, face_encoding) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            header("Location: admin_gate.php?error=failed");
            exit();
        }
        $stmt->bind_param("ssss", $username, $email, $hashed_pass, $face_encoding);

        if ($stmt->execute()) {
            header("Location: admin_gate.php?auth=setup_complete");
            exit();
        }
        header("Location: admin_gate.php?error=failed");
        exit();
    }

    if ($auth_mode === 'biometric') {
        $stmt = $conn->prepare("SELECT id, username, face_encoding FROM admins WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            $stored_face = $admin['face_encoding'] ?? '';
            $authenticated = false;

            if (!empty($stored_face) && !empty($face_encoding)) {
                if ($stored_face === $face_encoding) {
                    $authenticated = true;
                } else {
                    $stored_json = json_decode($stored_face, true);
                    $captured_json = json_decode($face_encoding, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($stored_json) && is_array($captured_json) && count($stored_json) > 0 && count($captured_json) > 0) {
                        $dot = 0.0;
                        $magA = 0.0;
                        $magB = 0.0;
                        $len = min(count($stored_json), count($captured_json));
                        for ($i = 0; $i < $len; $i++) {
                            $a = floatval($stored_json[$i]);
                            $b = floatval($captured_json[$i]);
                            $dot += $a * $b;
                            $magA += $a * $a;
                            $magB += $b * $b;
                        }
                        if ($magA > 0 && $magB > 0 && ($dot / (sqrt($magA) * sqrt($magB))) >= 0.80) {
                            $authenticated = true;
                        }
                    }
                }
            }

            if ($authenticated) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                unset($_SESSION['admin_failed_attempts'], $_SESSION['admin_lockout_expires']);
                header("Location: admin.php");
                exit();
            }
        }

        $_SESSION['admin_failed_attempts'] = ($_SESSION['admin_failed_attempts'] ?? 0) + 1;
        if ($_SESSION['admin_failed_attempts'] >= 3) {
            $_SESSION['admin_lockout_expires'] = time() + 300;
            unset($_SESSION['admin_failed_attempts']);
            header("Location: admin_gate.php?error=locked");
            exit();
        }

        header("Location: admin_gate.php?error=invalid_credentials");
        exit();
    }

    if ($auth_mode === 'login') {
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                unset($_SESSION['admin_failed_attempts'], $_SESSION['admin_lockout_expires']);
                header("Location: admin.php");
                exit();
            }
        }

        $_SESSION['admin_failed_attempts'] = ($_SESSION['admin_failed_attempts'] ?? 0) + 1;
        if ($_SESSION['admin_failed_attempts'] >= 3) {
            $_SESSION['admin_lockout_expires'] = time() + 300;
            unset($_SESSION['admin_failed_attempts']);
            header("Location: admin_gate.php?error=locked");
            exit();
        }
        header("Location: admin_gate.php?error=invalid_credentials");
        exit();
    }

    header("Location: admin_gate.php?error=invalid_credentials");
    exit();
}
