<?php
session_start();

require_once('roleCheck.php');
requireRole('admin');

require_once('../models/userModel.php');

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['user_error'] = 'Invalid user id.';
    header('location: ../views/admin/users.php');
    exit();
}

if ((int)($_SESSION['user_id'] ?? 0) === $id) {
    $_SESSION['user_error'] = "You can't delete your own account.";
    header('location: ../views/admin/users.php');
    exit();
}

$deleted = deleteUser($id);

if ($deleted) {
    $_SESSION['user_success'] = 'User deleted.';
    header('location: ../views/admin/users.php');
    exit();
}

$_SESSION['user_error'] = 'Failed to delete user.';
header('location: ../views/admin/users.php');
exit();

?>
