<?php
require_once('roleCheck.php');
requireRole('librarian');
require_once('../models/db.php');

if(!isset($_POST['submit'])){
    header('location: ../views/librarian/return.php');
    exit();
}

$borrowId = intval($_POST['borrow_id'] ?? 0);
if($borrowId <= 0){
    echo "Invalid input!";
    exit();
}

$conn = getConnection();

$sql = "SELECT due_date FROM borrowings WHERE id={$borrowId} AND status='issued'";
$result = mysqli_query($conn, $sql);

if(!$result || mysqli_num_rows($result) == 0){
    echo "Invalid input!";
    exit();
}

$row = mysqli_fetch_assoc($result);
$dueDate = $row['due_date'];

$today = date('Y-m-d');
$fine = 0;

if(strtotime($today) > strtotime($dueDate)){
    $daysLate = (strtotime($today) - strtotime($dueDate)) / (60*60*24);
    $fine = intval($daysLate) * 5;
}

$sql2 = "UPDATE borrowings SET status='returned', fine={$fine}, return_date='{$today}' WHERE id={$borrowId}";
$status = mysqli_query($conn, $sql2);

if($status){
    header('location: ../views/librarian/return.php');
    exit();
}

echo "Return failed!";
exit();
