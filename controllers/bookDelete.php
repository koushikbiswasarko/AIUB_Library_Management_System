<?php
require_once('roleCheck.php');
requireRole('admin');
require_once('../models/bookModel.php');

$bookId = intval($_GET['id'] ?? 0);

if ($bookId <= 0) {
    header('location: ../views/admin/bookList.php');
    exit();
}

deleteBook($bookId);

header('location: ../views/admin/bookList.php');
exit();
