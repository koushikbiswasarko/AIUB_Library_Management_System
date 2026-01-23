<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');

require_once('../../models/userModel.php');
require_once('../../models/bookModel.php');

$studentListResult = getAllStudents();
$bookListResult = getAllBooksForIssue();

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Issue Book</h2>
      <p>Select a student and a book to issue.</p>
    </div>

    <div class="box">
      <form method="post" action="../../controllers/issueCheck.php">

        <label>Select Student</label>
        <select name="user_id" required>
          <?php while($studentRow = mysqli_fetch_assoc($studentListResult)){ ?>
            <option value="<?= $studentRow['id'] ?>">
              <?= htmlspecialchars($studentRow['username']) ?>
            </option>
          <?php } ?>
        </select>
        <br><br>

        <label>Select Book</label>
        <select name="book_id" required>
          <?php while($bookRow = mysqli_fetch_assoc($bookListResult)){ ?>
            <option value="<?= $bookRow['id'] ?>">
              <?= htmlspecialchars($bookRow['title']) ?> (Available: <?= $bookRow['available_copies'] ?>)
            </option>
          <?php } ?>
        </select>
        <br><br>

        <button type="submit" name="submit">Issue</button>
      </form>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
