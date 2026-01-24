<?php
require_once('../../controllers/roleCheck.php');
requireRole('student');

require_once('../../models/borrowModel.php');

$currentStudentId = intval($_SESSION['user_id'] ?? 0);
$myBorrowingsResult = getBorrowings($currentStudentId);

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/studentMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>My Borrowings</h2>
      <div class="box">
        <table>
          <tr>
            <th>Book</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Fine</th>
          </tr>

          <?php while($myBorrowingRow = mysqli_fetch_assoc($myBorrowingsResult)){ ?>
          <tr>
            <td><?php echo htmlspecialchars($myBorrowingRow['title']); ?></td>
            <td><?php echo htmlspecialchars($myBorrowingRow['issue_date']); ?></td>
            <td><?php echo htmlspecialchars($myBorrowingRow['due_date']); ?></td>
            <td><?php echo htmlspecialchars($myBorrowingRow['return_date']); ?></td>
            <td><?php echo htmlspecialchars($myBorrowingRow['status']); ?></td>
            <td><?php echo htmlspecialchars($myBorrowingRow['fine']); ?></td>
          </tr>
          <?php } ?>

        </table>
      </div>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
