<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/db.php');

$conn = getConnection();

$r1 = mysqli_query($conn, "SELECT COUNT(*) AS c FROM books");
$a = mysqli_fetch_assoc($r1);

$r2 = mysqli_query($conn, "SELECT COUNT(*) AS c FROM borrowings WHERE status='issued'");
$b = mysqli_fetch_assoc($r2);

$r3 = mysqli_query($conn, "SELECT COUNT(*) AS c FROM borrowings WHERE status='issued' AND due_date < CURDATE()");
$c = mysqli_fetch_assoc($r3);

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
      <h2><?php echo $a['c']; ?></h2>
      <p>Total Books</p>
    </div>

    <div class="stat">
      <h2><?php echo $b['c']; ?></h2>
      <p>Issued Books</p>
    </div>

    <div class="stat">
      <h2><?php echo $c['c']; ?></h2>
      <p>Overdue Books</p>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
