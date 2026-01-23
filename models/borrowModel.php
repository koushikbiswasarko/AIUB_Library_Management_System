<?php
require_once('db.php');

// Simple mysqli_query() versions (no bind_param)

function getIssuedList(){
    $databaseConnection = getConnection();

    $sqlQuery = "
        SELECT br.*, u.username, b.title
        FROM borrowings br
        JOIN users u ON br.user_id = u.id
        JOIN books b ON br.book_id = b.id
        WHERE br.status = 'issued'
        ORDER BY br.id DESC
    ";

    return mysqli_query($databaseConnection, $sqlQuery);
}

function getOverdueList(){
    $databaseConnection = getConnection();

    $sqlQuery = "
        SELECT br.*, u.username, b.title
        FROM borrowings br
        JOIN users u ON br.user_id = u.id
        JOIN books b ON br.book_id = b.id
        WHERE br.status = 'issued' AND br.due_date < CURDATE()
        ORDER BY br.due_date ASC
    ";

    return mysqli_query($databaseConnection, $sqlQuery);
}

function getBorrowingsByStudentId($studentId){
    $databaseConnection = getConnection();
    $studentIdInteger = (int)($studentId ?? 0);
    if ($studentIdInteger <= 0) {
        return false;
    }

    $sqlQuery = "
        SELECT br.issue_date, br.due_date, br.return_date, br.status, br.fine, b.title
        FROM borrowings br
        JOIN books b ON br.book_id = b.id
        WHERE br.user_id = $studentIdInteger
        ORDER BY br.id DESC
    ";

    return mysqli_query($databaseConnection, $sqlQuery);
}

function issueBook($userId, $bookId, $issueDate, $dueDate){
    $databaseConnection = getConnection();

    $userIdInteger = (int)($userId ?? 0);
    $bookIdInteger = (int)($bookId ?? 0);
    $issueDateValue = trim($issueDate ?? "");
    $dueDateValue = trim($dueDate ?? "");

    if ($userIdInteger <= 0 || $bookIdInteger <= 0 || $issueDateValue === "" || $dueDateValue === "") {
        return false;
    }

    $safeIssueDate = mysqli_real_escape_string($databaseConnection, $issueDateValue);
    $safeDueDate = mysqli_real_escape_string($databaseConnection, $dueDateValue);

    mysqli_begin_transaction($databaseConnection);

    try {
        // 1) Check stock
        $checkSql = "SELECT available_copies FROM books WHERE id=$bookIdInteger LIMIT 1";
        $checkResult = mysqli_query($databaseConnection, $checkSql);
        $bookRow = $checkResult ? mysqli_fetch_assoc($checkResult) : null;

        if (!$bookRow || (int)$bookRow['available_copies'] <= 0) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        // 2) Insert borrowing
        $insertSql = "INSERT INTO borrowings (user_id, book_id, issue_date, due_date, status)
                      VALUES ($userIdInteger, $bookIdInteger, '$safeIssueDate', '$safeDueDate', 'issued')";
        $isInserted = mysqli_query($databaseConnection, $insertSql);

        if (!$isInserted) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        // 3) Decrease available copies
        $updateSql = "UPDATE books SET available_copies = available_copies - 1 WHERE id=$bookIdInteger";
        $isUpdated = mysqli_query($databaseConnection, $updateSql);

        if (!$isUpdated) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        mysqli_commit($databaseConnection);
        return true;

    } catch (Exception $exception) {
        mysqli_rollback($databaseConnection);
        return false;
    }
}

function returnBook($borrowId, $fine){
    $databaseConnection = getConnection();

    $borrowIdInteger = (int)($borrowId ?? 0);
    $fineAmount = (float)($fine ?? 0);

    if ($borrowIdInteger <= 0 || $fineAmount < 0) {
        return false;
    }

    $todayDate = date('Y-m-d');
    $safeTodayDate = mysqli_real_escape_string($databaseConnection, $todayDate);
    $safeFine = (float)$fineAmount; // numeric

    mysqli_begin_transaction($databaseConnection);

    try {
        // 1) Find borrowing (must be issued)
        $borrowSql = "SELECT book_id FROM borrowings WHERE id=$borrowIdInteger AND status='issued' LIMIT 1";
        $borrowResult = mysqli_query($databaseConnection, $borrowSql);
        $borrowRow = $borrowResult ? mysqli_fetch_assoc($borrowResult) : null;

        if (!$borrowRow) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        $bookIdInteger = (int)$borrowRow['book_id'];

        // 2) Update borrowing
        $updateBorrowSql = "UPDATE borrowings
                            SET return_date='$safeTodayDate', fine=$safeFine, status='returned'
                            WHERE id=$borrowIdInteger";
        $isBorrowUpdated = mysqli_query($databaseConnection, $updateBorrowSql);

        if (!$isBorrowUpdated) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        // 3) Increase book availability
        $updateBookSql = "UPDATE books SET available_copies = available_copies + 1 WHERE id=$bookIdInteger";
        $isBookUpdated = mysqli_query($databaseConnection, $updateBookSql);

        if (!$isBookUpdated) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        mysqli_commit($databaseConnection);
        return true;

    } catch (Exception $exception) {
        mysqli_rollback($databaseConnection);
        return false;
    }
}

?>
