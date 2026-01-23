<?php
session_start();

require_once('roleCheck.php');
requireRole('admin');

require_once('../models/userModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/admin/users.php');
    exit();
}

$userName = trim($_POST['username'] ?? "");
$userEmail = trim($_POST['email'] ?? "");
$userPassword = trim($_POST['password'] ?? "");
$userRole = trim($_POST['role'] ?? "student");

if ($userName === "" || $userEmail === "" || $userPassword === "") {
    $_SESSION['user_error'] = 'Please fill in all fields.';
    header('location: ../views/admin/users.php');
    exit();
}

if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['user_error'] = 'Invalid email format.';
    header('location: ../views/admin/users.php');
    exit();
}

if (strlen($userPassword) < 4) {
    $_SESSION['user_error'] = 'Password should be at least 4 characters.';
    header('location: ../views/admin/users.php');
    exit();
}

if (isUsernameTaken($userName)) {
    $_SESSION['user_error'] = 'Username already exists. Try another one.';
    header('location: ../views/admin/users.php');
    exit();
}

$created = createUser($userName, $userPassword, $userEmail, $userRole);

if ($created) {
    $_SESSION['user_success'] = 'User created successfully.';
    header('location: ../views/admin/users.php');
    exit();
}

$_SESSION['user_error'] = 'Failed to create user.';
header('location: ../views/admin/users.php');
exit();

?>
