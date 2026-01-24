<?php
require_once('db.php');

function getAllBooks(){
    $conn = getConnection();
    $sql = "SELECT * FROM books ORDER BY title ASC";
    return mysqli_query($conn, $sql);
}

function getAllBooksForIssue(){
    $conn = getConnection();
    $sql = "SELECT id, title, available_copies FROM books ORDER BY title ASC";
    return mysqli_query($conn, $sql);
}

function getBook($bookId){
    $conn = getConnection();

    $id = (int)$bookId;
    if($id <= 0){
        return null;
    }

    $sql = "SELECT * FROM books WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) == 1){
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function addBook($bookData){
    $conn = getConnection();

    $title = $bookData['title'];
    $author = $bookData['author'];
    $category = $bookData['category'];
    $total = (int)$bookData['total_copies'];
    $available = (int)$bookData['available_copies'];

    if($title == "" || $author == "" || $category == ""){
        return false;
    }

    $sql = "INSERT INTO books (title, author, category, total_copies, available_copies)
            VALUES ('$title', '$author', '$category', $total, $available)";

    return mysqli_query($conn, $sql);
}

function updateBook($bookData){
    $conn = getConnection();

    $id = (int)$bookData['id'];
    $title = $bookData['title'];
    $author = $bookData['author'];
    $category = $bookData['category'];
    $total = (int)$bookData['total_copies'];
    $available = (int)$bookData['available_copies'];

    if($id <= 0 || $title == "" || $author == "" || $category == ""){
        return false;
    }

    $sql = "UPDATE books SET
            title='$title',
            author='$author',
            category='$category',
            total_copies=$total,
            available_copies=$available
            WHERE id=$id";

    return mysqli_query($conn, $sql);
}

function deleteBook($bookId){
    $conn = getConnection();

    $id = (int)$bookId;
    if($id <= 0){
        return false;
    }

    $sql = "DELETE FROM books WHERE id=$id";
    return mysqli_query($conn, $sql);
}
?>
