<?php
session_start();

require_once('../models/userModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/auth/forgot_password.php');
    exit();
}

$userName = trim($_POST['username'] ?? "");
$newPassword = trim($_POST['new_password'] ?? "");
$confirmPassword = trim($_POST['confirm_password'] ?? "");

if ($userName === "" || $newPassword === "" || $confirmPassword === "") {
    $_SESSION['forgot_error'] = 'Please fill in all fields.';
    header('location: ../views/auth/forgot_password.php');
    exit();
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['forgot_error'] = 'New password and Confirm password do not match.';
    header('location: ../views/auth/forgot_password.php');
    exit();
}

if (strlen($newPassword) < 4) {
    $_SESSION['forgot_error'] = 'Password should be at least 4 characters.';
    header('location: ../views/auth/forgot_password.php');
    exit();
}

// NOTE: This is a demo-friendly reset (no email). In real apps, use tokens + email.
if (!isUsernameTaken($userName)) {
    $_SESSION['forgot_error'] = 'Username not found.';
    header('location: ../views/auth/forgot_password.php');
    exit();
}

$updated = updatePasswordByUsername($userName, $newPassword);

if ($updated) {
    $_SESSION['signup_success'] = 'Password reset successful! Please login.';
    header('location: ../views/auth/login.php');
    exit();
}

$_SESSION['forgot_error'] = 'Password reset failed. Please try again.';
header('location: ../views/auth/forgot_password.php');
exit();

?>
