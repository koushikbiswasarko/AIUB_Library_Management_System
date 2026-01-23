<?php
require_once('roleCheck.php');
requireRole('admin');
require_once('../models/bookModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/admin/booklist.php');
    exit();
}

$bookId = intval($_POST['id'] ?? 0);
$bookTitle = trim($_POST['title'] ?? "");
$authorName = trim($_POST['author'] ?? "");
$bookCategory = trim($_POST['category'] ?? "");
$totalCopies = intval($_POST['total_copies'] ?? -1);
$availableCopies = intval($_POST['available_copies'] ?? -1);

if ($bookId <= 0 || $bookTitle === "" || $authorName === "" || $totalCopies < 0 || $availableCopies < 0) {
    echo "Invalid input! Please fill correctly.";
    exit();
}

if ($availableCopies > $totalCopies) {
    echo "Invalid input! Available copies cannot be greater than total copies.";
    exit();
}

$bookData = [
    'id' => $bookId,
    'title' => $bookTitle,
    'author' => $authorName,
    'category' => $bookCategory,
    'total_copies' => $totalCopies,
    'available_copies' => $availableCopies
];

$isUpdated = updateBook($bookData);

if ($isUpdated) {
    header('location: ../views/admin/booklist.php');
    exit();
}

echo "DB error! Book could not be updated.";
exit();
