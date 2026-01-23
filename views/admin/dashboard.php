<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/db.php');

$databaseConnection = getConnection();

$totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
$totalBooksResult = mysqli_query($databaseConnection, $totalBooksQuery);
$totalBooksRow = mysqli_fetch_assoc($totalBooksResult);
$totalBooks = $totalBooksRow['total_books'];

$issuedBooksQuery = "SELECT COUNT(*) AS issued_books FROM borrowings WHERE status='issued'";
$issuedBooksResult = mysqli_query($databaseConnection, $issuedBooksQuery);
$issuedBooksRow = mysqli_fetch_assoc($issuedBooksResult);
$issuedBooks = $issuedBooksRow['issued_books'];

$overdueBooksQuery = "SELECT COUNT(*) AS overdue_books FROM borrowings WHERE status='issued' AND due_date < CURDATE()";
$overdueBooksResult = mysqli_query($databaseConnection, $overdueBooksQuery);
$overdueBooksRow = mysqli_fetch_assoc($overdueBooksResult);
$overdueBooks = $overdueBooksRow['overdue_books'];

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Admin Dashboard</h2>
      <p>Library Overview</p>
    </div>

    <div class="stat">
      <h2><?= $totalBooks ?></h2>
      <p>Total Books</p>
    </div>

    <div class="stat">
      <h2><?= $issuedBooks ?></h2>
      <p>Issued Books</p>
    </div>

    <div class="stat">
      <h2><?= $overdueBooks ?></h2>
      <p>Overdue Books</p>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
