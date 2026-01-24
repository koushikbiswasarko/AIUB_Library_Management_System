<?php
session_start();

require_once('../models/userModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/auth/signup.php');
    exit();
}

$userName = trim($_POST['username'] ?? "");
$userEmail = trim($_POST['email'] ?? "");
$userPassword = trim($_POST['password'] ?? "");
$confirmPassword = trim($_POST['confirm_password'] ?? "");

$userRole = 'student';

if ($userName === "" || $userEmail === "" || $userPassword === "" || $confirmPassword === "") {
    $_SESSION['signup_error'] = 'Please fill in all fields.';
    header('location: ../views/auth/signup.php');
    exit();
}

if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup_error'] = 'Invalid email format.';
    header('location: ../views/auth/signup.php');
    exit();
}

if ($userPassword !== $confirmPassword) {
    $_SESSION['signup_error'] = 'Password and Confirm Password do not match.';
    header('location: ../views/auth/signup.php');
    exit();
}

if (strlen($userPassword) < 4) {
    $_SESSION['signup_error'] = 'Password should be at least 4 characters.';
    header('location: ../views/auth/signup.php');
    exit();
}

if (isUsernameTaken($userName)) {
    $_SESSION['signup_error'] = 'Username already exists. Try another one.';
    header('location: ../views/auth/signup.php');
    exit();
}

if (isUserEmailTaken($userEmail)) {
    $_SESSION['signup_error'] = 'Email already exists. Try another one.';
    header('location: ../views/auth/signup.php');
    exit();
}

$created = createUser($userName, $userPassword, $userEmail, $userRole);

if ($created) {
    $_SESSION['signup_success'] = 'Account created successfully! Please login.';
    header('location: ../views/auth/login.php');
    exit();
}

$_SESSION['signup_error'] = 'Signup failed. Please try again.';
header('location: ../views/auth/signup.php');
exit();

?>
