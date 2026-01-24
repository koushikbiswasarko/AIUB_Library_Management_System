<?php
require_once('roleCheck.php');
requireRole('admin');
require_once('../models/bookModel.php');

if (!isset($_POST['submit'])) {
    header('location: ../views/admin/addBook.php');
    exit();
}

$bookTitle = trim($_POST['title'] ?? "");
$authorName = trim($_POST['author'] ?? "");
$bookCategory = trim($_POST['category'] ?? "");
$totalCopies = intval($_POST['total_copies'] ?? 0);

if ($bookTitle === "" || $authorName === "" || $totalCopies <= 0) {
    echo "Invalid input! Title, Author and Total Copies are required.";
    exit();
}

$bookData = [
    'title' => $bookTitle,
    'author' => $authorName,
    'category' => $bookCategory,
    'total_copies' => $totalCopies,
    'available_copies' => $totalCopies
];

$isAdded = addBook($bookData);

if ($isAdded) {
    header('location: ../views/admin/bookList.php');
    exit();
}

echo "DB error! Book could not be added.";
exit();
