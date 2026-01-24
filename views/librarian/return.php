<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');

require_once('../../models/borrowModel.php');

$result = getIssuedList();

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Return Book</h2>
      <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
          <th>Student</th>
          <th>Book</th>
          <th>Due Date</th>
          <th>Action</th>
        </tr>

        <?php if($result && mysqli_num_rows($result) > 0){ ?>
          <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo $row['due_date']; ?></td>
              <td>
                <form method="post" action="../../controllers/returnCheck.php" style="margin:0;">
                  <input type="hidden" name="borrow_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="submit">Return</button>
                </form>
              </td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr><td colspan="4">No issued books found.</td></tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
