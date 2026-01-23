<?php
require_once('roleCheck.php');
requireRole('librarian');
require_once('../models/borrowModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/librarian/issue.php');
    exit();
}

$userId = intval($_POST['user_id'] ?? 0);
$bookId = intval($_POST['book_id'] ?? 0);

if ($userId <= 0 || $bookId <= 0) {
    echo "Invalid input!";
    exit();
}

$issueDate = date('Y-m-d');
$dueDate = date('Y-m-d', strtotime('+7 days'));

$isIssued = issueBook($userId, $bookId, $issueDate, $dueDate);

if ($isIssued) {
    header('location: ../views/librarian/dashboard.php');
    exit();
}

echo "Issue failed (book may be unavailable).";
exit();
