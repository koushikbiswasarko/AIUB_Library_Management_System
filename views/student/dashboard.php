<?php
require_once('../../controllers/roleCheck.php');
requireRole('student');
require_once('../../models/db.php');

$databaseConnection = getConnection();
$currentStudentId = $_SESSION['user_id'];

$myIssuedQuery = "SELECT COUNT(*) AS my_issued FROM borrowings WHERE user_id=$currentStudentId AND status='issued'";
$myIssuedResult = mysqli_query($databaseConnection, $myIssuedQuery);
$myIssuedRow = mysqli_fetch_assoc($myIssuedResult);
$myIssuedBooks = $myIssuedRow['my_issued'];

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/studentMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Student Dashboard</h2>
      <p>My Library Summary</p>
    </div>

    <div class="stat">
      <h2><?= $myIssuedBooks ?></h2>
      <p>My Issued Books</p>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
