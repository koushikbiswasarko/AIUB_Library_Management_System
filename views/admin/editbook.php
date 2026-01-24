<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/bookModel.php');

$id = (int)$_GET['id'];
$book = getBook($id);

if(!$book){
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
      <form method="post" action="../../controllers/bookUpdateCheck.php">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

        <label style="padding: 10px;">Book Title</label>
        <input type="text" style="width:35%" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

        <label style="padding: 10px;">Author Name</label>
        <input type="text" style="width:35%" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

        <br><br>

        <label style="padding: 10px;">Category</label>
        <input type="text" style="width:35%" name="category" value="<?php echo htmlspecialchars($book['category']); ?>">

        <label style="padding: 10px;">Total Copies</label>
        <input type="number" style="width:35%" name="total_copies" value="<?php echo $book['total_copies']; ?>" min="0" required>
        
        <br><br>

        <label style="padding: 10px;">Available Copies</label>
        <input type="number" style="width:35%" name="available_copies" value="<?php echo $book['available_copies']; ?>" min="0" required>
        <br><br>

        <button type="submit" name="submit">Update Book</button>
      </form>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
