<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true');

if (!$isLoggedIn) {
    header('location: ../views/auth/login.php');
    exit();
}
