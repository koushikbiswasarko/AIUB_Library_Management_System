<?php
require_once('roleCheck.php');
requireRole('librarian');

require_once('../models/borrowModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/librarian/issue.php');
    exit();
}

$userId = (int)($_POST['user_id'] ?? 0);
$bookId = (int)($_POST['book_id'] ?? 0);
$dueDate = trim($_POST['due_date'] ?? '');

if ($userId <= 0 || $bookId <= 0) {
    echo "Invalid input!";
    exit();
}

$issueDate = date('Y-m-d');

if ($dueDate === '') {
    $dueDate = date('Y-m-d', strtotime('+7 days'));
}

$ok = issueBook($userId, $bookId, $issueDate, $dueDate);

if ($ok) {
    header('location: ../views/librarian/dashboard.php');
    exit();
}

echo "Issue failed (book may be unavailable).";
exit();
