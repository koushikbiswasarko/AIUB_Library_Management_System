<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

setcookie('status', 'false', time() - 3600, '/');
session_destroy();

header('location: ../views/auth/login.php');
exit();
