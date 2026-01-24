<?php
require_once('db.php');

function getIssuedList(){
    $conn = getConnection();

    $sql = "SELECT br.*, u.username, b.title
            FROM borrowings br
            JOIN users u ON br.user_id = u.id
            JOIN books b ON br.book_id = b.id
            WHERE br.status = 'issued'
            ORDER BY br.due_date ASC";

    return mysqli_query($conn, $sql);
}

function getOverdueList(){
    $conn = getConnection();

    $sql = "SELECT br.*, u.username, b.title
            FROM borrowings br
            JOIN users u ON br.user_id = u.id
            JOIN books b ON br.book_id = b.id
            WHERE br.status = 'issued'
            AND br.due_date < CURDATE()
            ORDER BY br.due_date ASC";

    return mysqli_query($conn, $sql);
}

function getBorrowings($studentId){
    $conn = getConnection();

    $id = (int)$studentId;
    if($id <= 0){
        return false;
    }

    $sql = "SELECT br.issue_date, br.due_date, br.return_date, br.status, br.fine, b.title
            FROM borrowings br
            JOIN books b ON br.book_id = b.id
            WHERE br.user_id = $id
            ORDER BY br.due_date ASC";

    return mysqli_query($conn, $sql);
}

function issueBook($userId, $bookId, $issueDate, $dueDate){
    $conn = getConnection();

    $userId = (int)$userId;
    $bookId = (int)$bookId;

    if($userId <= 0 || $bookId <= 0 || $issueDate == "" || $dueDate == ""){
        return false;
    }

    mysqli_begin_transaction($conn);

    $checkSql = "SELECT available_copies FROM books WHERE id = $bookId";
    $checkResult = mysqli_query($conn, $checkSql);
    $book = mysqli_fetch_assoc($checkResult);

    if(!$book || $book['available_copies'] <= 0){
        mysqli_rollback($conn);
        return false;
    }

    $insertSql = "INSERT INTO borrowings (user_id, book_id, issue_date, due_date, status)
                  VALUES ($userId, $bookId, '$issueDate', '$dueDate', 'issued')";

    if(!mysqli_query($conn, $insertSql)){
        mysqli_rollback($conn);
        return false;
    }

    $updateSql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = $bookId";

    if(!mysqli_query($conn, $updateSql)){
        mysqli_rollback($conn);
        return false;
    }

    mysqli_commit($conn);
    return true;
}

function returnBook($borrowId, $fine){
    $conn = getConnection();

    $borrowId = (int)$borrowId;
    $fine = (float)$fine;

    if($borrowId <= 0 || $fine < 0){
        return false;
    }

    $today = date('Y-m-d');

    mysqli_begin_transaction($conn);

    $borrowSql = "SELECT book_id FROM borrowings WHERE id = $borrowId AND status = 'issued'";
    $borrowResult = mysqli_query($conn, $borrowSql);
    $borrow = mysqli_fetch_assoc($borrowResult);

    if(!$borrow){
        mysqli_rollback($conn);
        return false;
    }

    $bookId = (int)$borrow['book_id'];

    $updateBorrowSql = "UPDATE borrowings
                        SET return_date = '$today',
                            fine = $fine,
                            status = 'returned'
                        WHERE id = $borrowId";

    if(!mysqli_query($conn, $updateBorrowSql)){
        mysqli_rollback($conn);
        return false;
    }

    $updateBookSql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = $bookId";

    if(!mysqli_query($conn, $updateBookSql)){
        mysqli_rollback($conn);
        return false;
    }

    mysqli_commit($conn);
    return true;
}
?>
