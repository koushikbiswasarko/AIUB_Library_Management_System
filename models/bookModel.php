<?php
require_once('db.php');

// Simple mysqli_query() versions (no bind_param)

function getAllBooks(){
    $databaseConnection = getConnection();
    $sqlQuery = "SELECT * FROM books ORDER BY id DESC";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function getAllBooksForIssue(){
    $databaseConnection = getConnection();
    $sqlQuery = "SELECT id, title, available_copies FROM books ORDER BY id DESC";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function getBookById($bookId){
    $databaseConnection = getConnection();
    $id = (int)($bookId ?? 0);
    if ($id <= 0) {
        return null;
    }

    $sqlQuery = "SELECT * FROM books WHERE id=$id LIMIT 1";
    $result = mysqli_query($databaseConnection, $sqlQuery);
    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function addBook($bookData){
    $databaseConnection = getConnection();

    $bookTitle = trim($bookData['title'] ?? "");
    $authorName = trim($bookData['author'] ?? "");
    $bookCategory = trim($bookData['category'] ?? "");
    $totalCopies = (int)($bookData['total_copies'] ?? 0);
    $availableCopies = (int)($bookData['available_copies'] ?? 0);

    if ($bookTitle === "" || $authorName === "" || $bookCategory === "") {
        return false;
    }

    $safeTitle = mysqli_real_escape_string($databaseConnection, $bookTitle);
    $safeAuthor = mysqli_real_escape_string($databaseConnection, $authorName);
    $safeCategory = mysqli_real_escape_string($databaseConnection, $bookCategory);

    $sqlQuery = "INSERT INTO books (title, author, category, total_copies, available_copies)
                VALUES ('$safeTitle', '$safeAuthor', '$safeCategory', $totalCopies, $availableCopies)";

    return mysqli_query($databaseConnection, $sqlQuery);
}

function updateBook($bookData){
    $databaseConnection = getConnection();

    $bookId = (int)($bookData['id'] ?? 0);
    $bookTitle = trim($bookData['title'] ?? "");
    $authorName = trim($bookData['author'] ?? "");
    $bookCategory = trim($bookData['category'] ?? "");
    $totalCopies = (int)($bookData['total_copies'] ?? 0);
    $availableCopies = (int)($bookData['available_copies'] ?? 0);

    if ($bookId <= 0 || $bookTitle === "" || $authorName === "" || $bookCategory === "") {
        return false;
    }

    $safeTitle = mysqli_real_escape_string($databaseConnection, $bookTitle);
    $safeAuthor = mysqli_real_escape_string($databaseConnection, $authorName);
    $safeCategory = mysqli_real_escape_string($databaseConnection, $bookCategory);

    $sqlQuery = "UPDATE books SET
                    title='$safeTitle',
                    author='$safeAuthor',
                    category='$safeCategory',
                    total_copies=$totalCopies,
                    available_copies=$availableCopies
                WHERE id=$bookId";

    return mysqli_query($databaseConnection, $sqlQuery);
}

function deleteBook($bookId){
    $databaseConnection = getConnection();
    $id = (int)($bookId ?? 0);
    if ($id <= 0) {
        return false;
    }
    $sqlQuery = "DELETE FROM books WHERE id=$id";
    return mysqli_query($databaseConnection, $sqlQuery);
}

?>
