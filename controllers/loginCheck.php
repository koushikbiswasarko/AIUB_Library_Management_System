<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../models/userModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/auth/login.php');
    exit();
}

$userName = trim($_POST['username'] ?? "");
$userPassword = trim($_POST['password'] ?? "");

if ($userName === "" || $userPassword === "") {
    echo "Username and password required!";
    exit();
}

$userInput = [
    'username' => $userName,
    'password' => $userPassword
];

$userData = login($userInput);

if (!$userData) {
    echo "Invalid user!";
    exit();
}

setcookie('status', 'true', time() + 3000, '/');

$_SESSION['username'] = $userData['username'];
$_SESSION['role'] = $userData['role'];
$_SESSION['user_id'] = $userData['id'];

if ($userData['role'] === 'admin') {
    header('location: ../views/admin/dashboard.php');
} elseif ($userData['role'] === 'librarian') {
    header('location: ../views/librarian/dashboard.php');
} else {
    header('location: ../views/student/dashboard.php');
}
exit();
