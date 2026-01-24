<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true');

if (!$isLoggedIn) {
    header("Location: /AIUB_Library_Management_System/views/auth/login.php");
    exit();
}
