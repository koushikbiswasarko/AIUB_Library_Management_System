<?php
require_once('db.php');

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

    $sqlQuery = "SELECT * FROM books WHERE id = ?";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);

    $bookIdInteger = intval($bookId);
    mysqli_stmt_bind_param($statement, "i", $bookIdInteger);

    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    $bookData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($statement);

    return $bookData;
}

function addBook($bookData){
    $databaseConnection = getConnection();

    $sqlQuery = "INSERT INTO books (title, author, category, total_copies, available_copies)
                VALUES (?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);

    $bookTitle = trim($bookData['title'] ?? "");
    $authorName = trim($bookData['author'] ?? "");
    $bookCategory = trim($bookData['category'] ?? "");
    $totalCopies = intval($bookData['total_copies'] ?? 0);
    $availableCopies = intval($bookData['available_copies'] ?? 0);

    mysqli_stmt_bind_param($statement, "sssii", $bookTitle, $authorName, $bookCategory, $totalCopies, $availableCopies);

    $isInserted = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $isInserted;
}

function updateBook($bookData){
    $databaseConnection = getConnection();

    $sqlQuery = "UPDATE books SET
                    title = ?,
                    author = ?,
                    category = ?,
                    total_copies = ?,
                    available_copies = ?
                WHERE id = ?";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);

    $bookId = intval($bookData['id'] ?? 0);
    $bookTitle = trim($bookData['title'] ?? "");
    $authorName = trim($bookData['author'] ?? "");
    $bookCategory = trim($bookData['category'] ?? "");
    $totalCopies = intval($bookData['total_copies'] ?? 0);
    $availableCopies = intval($bookData['available_copies'] ?? 0);

    mysqli_stmt_bind_param($statement, "sssiii", $bookTitle, $authorName, $bookCategory, $totalCopies, $availableCopies, $bookId);

    $isUpdated = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $isUpdated;
}

function deleteBook($bookId){
    $databaseConnection = getConnection();

    $sqlQuery = "DELETE FROM books WHERE id = ?";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);

    $bookIdInteger = intval($bookId);
    mysqli_stmt_bind_param($statement, "i", $bookIdInteger);

    $isDeleted = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $isDeleted;
}
?>
