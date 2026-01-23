<?php
session_start();

require_once('roleCheck.php');
requireRole('admin');

require_once('../models/userModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/admin/users.php');
    exit();
}

$id = (int)($_POST['id'] ?? 0);
$role = trim($_POST['role'] ?? "");

if ($id <= 0 || $role === "") {
    $_SESSION['user_error'] = 'Invalid request.';
    header('location: ../views/admin/users.php');
    exit();
}

// Don't let admin change own role (avoid lock-out)
if ((int)($_SESSION['user_id'] ?? 0) === $id) {
    $_SESSION['user_error'] = "You can't change your own role.";
    header('location: ../views/admin/users.php');
    exit();
}

$updated = updateUserRoleById($id, $role);

if ($updated) {
    $_SESSION['user_success'] = 'Role updated.';
    header('location: ../views/admin/users.php');
    exit();
}

$_SESSION['user_error'] = 'Failed to update role.';
header('location: ../views/admin/users.php');
exit();

?>
