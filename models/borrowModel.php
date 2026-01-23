<?php
require_once('db.php');

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

    $sqlQuery = "
        SELECT br.issue_date, br.due_date, br.return_date, br.status, br.fine, b.title
        FROM borrowings br
        JOIN books b ON br.book_id = b.id
        WHERE br.user_id = ?
        ORDER BY br.id DESC
    ";

    $statement = mysqli_prepare($databaseConnection, $sqlQuery);
    $studentIdInteger = intval($studentId);
    mysqli_stmt_bind_param($statement, "i", $studentIdInteger);
    mysqli_stmt_execute($statement);

    return mysqli_stmt_get_result($statement); // mysqli_result
}

function issueBook($userId, $bookId, $issueDate, $dueDate){
    $databaseConnection = getConnection();

    $userIdInteger = intval($userId);
    $bookIdInteger = intval($bookId);
    $issueDateValue = trim($issueDate);
    $dueDateValue = trim($dueDate);

    if ($userIdInteger <= 0 || $bookIdInteger <= 0 || $issueDateValue === "" || $dueDateValue === "") {
        return false;
    }

    mysqli_begin_transaction($databaseConnection);

    try {
        $checkSql = "SELECT available_copies FROM books WHERE id = ? LIMIT 1";
        $checkStatement = mysqli_prepare($databaseConnection, $checkSql);
        mysqli_stmt_bind_param($checkStatement, "i", $bookIdInteger);
        mysqli_stmt_execute($checkStatement);

        $checkResult = mysqli_stmt_get_result($checkStatement);
        $bookRow = mysqli_fetch_assoc($checkResult);
        mysqli_stmt_close($checkStatement);

        if (!$bookRow || intval($bookRow['available_copies']) <= 0) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        $insertSql = "INSERT INTO borrowings (user_id, book_id, issue_date, due_date, status)
                      VALUES (?, ?, ?, ?, 'issued')";
        $insertStatement = mysqli_prepare($databaseConnection, $insertSql);
        mysqli_stmt_bind_param($insertStatement, "iiss", $userIdInteger, $bookIdInteger, $issueDateValue, $dueDateValue);

        $isInserted = mysqli_stmt_execute($insertStatement);
        mysqli_stmt_close($insertStatement);

        if (!$isInserted) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        $updateSql = "UPDATE books SET available_copies = available_copies - 1 WHERE id = ?";
        $updateStatement = mysqli_prepare($databaseConnection, $updateSql);
        mysqli_stmt_bind_param($updateStatement, "i", $bookIdInteger);

        $isUpdated = mysqli_stmt_execute($updateStatement);
        mysqli_stmt_close($updateStatement);

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

    $borrowIdInteger = intval($borrowId);
    $fineAmount = floatval($fine);

    if ($borrowIdInteger <= 0 || $fineAmount < 0) {
        return false;
    }

    $todayDate = date('Y-m-d');

    mysqli_begin_transaction($databaseConnection);

    try {
        $borrowSql = "SELECT book_id FROM borrowings WHERE id = ? AND status = 'issued' LIMIT 1";
        $borrowStatement = mysqli_prepare($databaseConnection, $borrowSql);
        mysqli_stmt_bind_param($borrowStatement, "i", $borrowIdInteger);

        mysqli_stmt_execute($borrowStatement);
        $borrowResult = mysqli_stmt_get_result($borrowStatement);
        $borrowRow = mysqli_fetch_assoc($borrowResult);
        mysqli_stmt_close($borrowStatement);

        if (!$borrowRow) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        $bookIdInteger = intval($borrowRow['book_id']);

        $updateBorrowSql = "UPDATE borrowings
                            SET return_date = ?, fine = ?, status = 'returned'
                            WHERE id = ?";
        $updateBorrowStatement = mysqli_prepare($databaseConnection, $updateBorrowSql);
        mysqli_stmt_bind_param($updateBorrowStatement, "sdi", $todayDate, $fineAmount, $borrowIdInteger);

        $isBorrowUpdated = mysqli_stmt_execute($updateBorrowStatement);
        mysqli_stmt_close($updateBorrowStatement);

        if (!$isBorrowUpdated) {
            mysqli_rollback($databaseConnection);
            return false;
        }

        $updateBookSql = "UPDATE books SET available_copies = available_copies + 1 WHERE id = ?";
        $updateBookStatement = mysqli_prepare($databaseConnection, $updateBookSql);
        mysqli_stmt_bind_param($updateBookStatement, "i", $bookIdInteger);

        $isBookUpdated = mysqli_stmt_execute($updateBookStatement);
        mysqli_stmt_close($updateBookStatement);

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
