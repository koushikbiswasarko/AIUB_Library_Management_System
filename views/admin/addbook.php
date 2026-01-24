<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Add Book</h2>
      <p>Fill the form to add a new book.</p>
    </div>

    <div class="box">
      <form method="post" action="../../controllers/bookAddCheck.php">
        <label style="padding: 10px;">Book Title: </label>
        <input type="text" name="title" required style="width:35%">
        <label style="padding: 10px;">Author Name: </label>
        <input type="text" name="author" required style="width:35%">
        <br><br>

        <label style="padding: 10px;">Category: </label>
        <input type="text" name="category" style="width:35%">
        <label style="padding: 10px;">Total Copies: </label>
        <input type="number" name="total_copies" value="1" min="1" required style="width:35%">
        <br><br>

        <button type="submit" name="submit">Add Book</button>
      </form>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
