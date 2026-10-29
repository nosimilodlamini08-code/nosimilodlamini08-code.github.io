<?php
session_start();
require_once 'config.php';

if (!isset($conn)) {
    if (isset($mysqli)) {
        $conn = $mysqli;
    } elseif (isset($connection)) {
        $conn = $connection;
    } else {
        die('Database connection not configured.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth_type = $_POST['auth_type'] ?? 'standard';
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        header("Location: login.php?auth_error=failed");
        exit();
    }

    if ($auth_type === 'biometric') {
        $captured_face = $_POST['face_encoding'] ?? '';

        $stmt = $conn->prepare("SELECT id, full_name, face_encoding, is_blocked FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ((int)$user['is_blocked'] === 1) {
                header("Location: login.php?auth_error=blocked");
                exit();
            }

            $stored_face = $user['face_encoding'] ?? '';

            // Helper: check if a string is valid JSON array
            $is_json_array = function ($s) {
                if (!is_string($s)) return false;
                $d = json_decode($s, true);
                return json_last_error() === JSON_ERROR_NONE && is_array($d);
            };

            // Compute cosine similarity for numeric vectors
            $cosine_similarity = function (array $a, array $b) {
                $len = min(count($a), count($b));
                if ($len === 0) return 0.0;
                $dot = 0.0;
                $na = 0.0;
                $nb = 0.0;
                for ($i = 0; $i < $len; $i++) {
                    $av = floatval($a[$i]);
                    $bv = floatval($b[$i]);
                    $dot += $av * $bv;
                    $na += $av * $av;
                    $nb += $bv * $bv;
                }
                if ($na <= 0 || $nb <= 0) return 0.0;
                return $dot / (sqrt($na) * sqrt($nb));
            };

            $biometric_ok = false;

            if ($is_json_array($stored_face) && $is_json_array($captured_face)) {
                $stored_vec = json_decode($stored_face, true);
                $captured_vec = json_decode($captured_face, true);
                $sim = $cosine_similarity($stored_vec, $captured_vec);
                // threshold: 0.80 (adjustable)
                if ($sim >= 0.80) {
                    $biometric_ok = true;
                }
            } else {
                // fallback to exact string match
                if (!empty($stored_face) && $stored_face === $captured_face) {
                    $biometric_ok = true;
                }
            }

            if ($biometric_ok) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];

                header("Location: " . (defined('BASE_URL') ? BASE_URL . 'index.php' : '/Bling_Rental_Company/index.php'));
                exit();
            }
        }
    } else {
        // Standard Form Gateway Handler Route
        $password = $_POST['password'] ?? '';

        $stmt = $conn->prepare("SELECT id, full_name, password, is_blocked FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ((int)$user['is_blocked'] === 1) {
                header("Location: login.php?auth_error=blocked");
                exit();
            }

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];

                header("Location: " . (defined('BASE_URL') ? BASE_URL . 'index.php' : '/Bling_Rental_Company/index.php'));
                exit();
            }
        }
    }
    header("Location: login.php?auth_error=failed");
    exit();
}
