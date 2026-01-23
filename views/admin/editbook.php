<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/bookModel.php');

$bookId = intval($_GET['id'] ?? 0);
$bookData = getBookById($bookId);
if(!$bookData){
    die("Book not found!");
}

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Edit Book</h2>
      <p>Update the book information.</p>
    </div>

    <div class="box">
      <form method="post" action="../../controllers/bookUpdateCheck.php">
        <input type="hidden" name="id" value="<?= $bookData['id'] ?>">

        <label>Book Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($bookData['title']) ?>" required>
        <br><br>

        <label>Author Name</label>
        <input type="text" name="author" value="<?= htmlspecialchars($bookData['author']) ?>" required>
        <br><br>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($bookData['category']) ?>">
        <br><br>

        <label>Total Copies</label>
        <input type="number" name="total_copies" value="<?= $bookData['total_copies'] ?>" min="0" required>
        <br><br>

        <label>Available Copies</label>
        <input type="number" name="available_copies" value="<?= $bookData['available_copies'] ?>" min="0" required>
        <br><br>

        <button type="submit" name="submit">Update Book</button>
      </form>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
