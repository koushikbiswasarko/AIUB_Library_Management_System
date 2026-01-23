<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');
require_once('../../models/db.php');

$databaseConnection = getConnection();

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
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Librarian Dashboard</h2>
      <p>Daily Operations</p>
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
