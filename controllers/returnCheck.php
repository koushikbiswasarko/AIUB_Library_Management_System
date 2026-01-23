<?php
require_once('roleCheck.php');
requireRole('librarian');
require_once('../models/borrowModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/librarian/return.php');
    exit();
}

$borrowId = intval($_POST['borrow_id'] ?? 0);
$dueDate = trim($_POST['due_date'] ?? "");

if ($borrowId <= 0 || $dueDate === "") {
    echo "Invalid input!";
    exit();
}

$todayDate = date('Y-m-d');
$fineAmount = 0;

if (strtotime($todayDate) > strtotime($dueDate)) {
    $daysLate = (strtotime($todayDate) - strtotime($dueDate)) / (60 * 60 * 24);
    $fineAmount = intval($daysLate) * 5;
}

$isReturned = returnBook($borrowId, $fineAmount);

if ($isReturned) {
    header('location: ../views/librarian/dashboard.php');
    exit();
}

echo "Return failed!";
exit();
