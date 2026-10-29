<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $face_encoding = $_POST['face_encoding'] ?? null;

    if (empty($fullname) || empty($email) || empty($password)) {
        header("Location: signup.php?error=missing_fields");
        exit();
    }

    // Encrypt security credentials string
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Verify if account identifier exists to block duplicate entries
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        header("Location: signup.php?error=email_taken");
        exit();
    }

    // Insert user cleanly into the persistence table layers, including optional biometric vector
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, face_encoding, is_blocked) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $fullname, $email, $hashed_password, $face_encoding);

    if ($stmt->execute()) {
        header("Location: login.php?registration=success");
    } else {
        header("Location: signup.php?error=database_failure");
    }
    exit();
}
