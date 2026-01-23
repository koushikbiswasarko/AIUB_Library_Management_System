<?php
require_once('../../controllers/roleCheck.php');
requireRole('student');
require_once('../../models/bookModel.php');
require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/studentMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Browse Books</h2>
      <p>Available book list.</p>
    </div>

    <div class="box">
      <table>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Available</th>
        </tr>

        <?php
        $allBooksResult = getAllBooks();
        while($bookRow = mysqli_fetch_assoc($allBooksResult)){
        ?>
        <tr>
          <td><?= htmlspecialchars($bookRow['title']) ?></td>
          <td><?= htmlspecialchars($bookRow['author']) ?></td>
          <td><?= htmlspecialchars($bookRow['category']) ?></td>
          <td><?= $bookRow['available_copies'] ?></td>
        </tr>
        <?php } ?>

      </table>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
