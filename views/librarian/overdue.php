<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');
require_once('../../models/db.php');

$conn = getConnection();

$sql = "
  SELECT br.id AS borrowing_id, br.due_date, u.username, b.title
  FROM borrowings br
  JOIN users u ON br.user_id=u.id
  JOIN books b ON br.book_id=b.id
  WHERE br.status='issued' AND br.due_date < CURDATE()
  ORDER BY br.due_date ASC
";
$result = mysqli_query($conn, $sql);

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Overdue List</h2>
      <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
          <th>Borrow ID</th>
          <th>Student</th>
          <th>Book</th>
          <th>Due Date</th>
        </tr>

        <?php if($result && mysqli_num_rows($result) > 0){ ?>
          <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr style="background-color:#ffe5e5;">
              <td><?php echo $row['borrowing_id']; ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo $row['due_date']; ?></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr><td colspan="4">No overdue books.</td></tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
