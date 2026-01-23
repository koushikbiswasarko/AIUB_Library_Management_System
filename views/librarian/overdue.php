<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');
require_once('../../models/db.php');

$databaseConnection = getConnection();

$overdueListQuery = "
  SELECT br.id AS borrowing_id, br.due_date, u.username, b.title
  FROM borrowings br
  JOIN users u ON br.user_id=u.id
  JOIN books b ON br.book_id=b.id
  WHERE br.status='issued' AND br.due_date < CURDATE()
  ORDER BY br.due_date ASC
";
$overdueListResult = mysqli_query($databaseConnection, $overdueListQuery);

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Overdue List</h2>
      <p>Books that are not returned within due date.</p>
    </div>

    <div class="box">
      <table>
        <tr>
          <th>Borrow ID</th>
          <th>Student</th>
          <th>Book</th>
          <th>Due Date</th>
        </tr>

        <?php while($overdueRow = mysqli_fetch_assoc($overdueListResult)){ ?>
        <tr style="background-color:#ffe5e5;">
          <td><?= $overdueRow['borrowing_id'] ?></td>
          <td><?= htmlspecialchars($overdueRow['username']) ?></td>
          <td><?= htmlspecialchars($overdueRow['title']) ?></td>
          <td><?= $overdueRow['due_date'] ?></td>
        </tr>
        <?php } ?>

      </table>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
