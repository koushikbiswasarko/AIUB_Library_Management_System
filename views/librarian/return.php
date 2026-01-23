<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');
require_once('../../models/db.php');

$databaseConnection = getConnection();

$issuedBorrowingsQuery = "
  SELECT br.id AS borrowing_id, br.due_date, u.username, b.title
  FROM borrowings br
  JOIN users u ON br.user_id=u.id
  JOIN books b ON br.book_id=b.id
  WHERE br.status='issued'
  ORDER BY br.id DESC
";
$issuedBorrowingsResult = mysqli_query($databaseConnection, $issuedBorrowingsQuery);

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Return Book</h2>
      <p>Select issued record to return.</p>
    </div>

    <div class="box">
      <form method="post" action="../../controllers/returnCheck.php">

        <label>Select Issued Record</label>
        <select name="borrow_id" id="borrow_id" onchange="setDueDateValue()" required>
          <?php
          $borrowDueDateMap = [];
          while($issuedRow = mysqli_fetch_assoc($issuedBorrowingsResult)){
              $borrowDueDateMap[$issuedRow['borrowing_id']] = $issuedRow['due_date'];
          ?>
            <option value="<?= $issuedRow['borrowing_id'] ?>">
              ID: <?= $issuedRow['borrowing_id'] ?> | <?= htmlspecialchars($issuedRow['username']) ?> | <?= htmlspecialchars($issuedRow['title']) ?> | Due: <?= $issuedRow['due_date'] ?>
            </option>
          <?php } ?>
        </select>

        <input type="hidden" name="due_date" id="due_date" value="<?= count($borrowDueDateMap) ? reset($borrowDueDateMap) : '' ?>">

        <br><br>
        <button type="submit" name="submit">Return</button>
      </form>
    </div>

  </div>
</div>

<script>
var borrowDueDateMap = <?= json_encode($borrowDueDateMap) ?>;

function setDueDateValue(){
    var selectedBorrowId = document.getElementById("borrow_id").value;
    document.getElementById("due_date").value = borrowDueDateMap[selectedBorrowId];
}
</script>

<?php require_once('../partials/footer.php'); ?>
