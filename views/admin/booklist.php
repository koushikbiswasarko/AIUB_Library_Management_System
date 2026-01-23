<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/bookModel.php');
require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Manage Books</h2>
      <a class="btn" href="addbook.php" style="background-color:#0d6efd;color:white;padding:10px;border-radius:5px;text-decoration:none;">+ Add Book</a>
    </div>

    <div class="box">
      <table>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Total</th>
          <th>Available</th>
          <th>Action</th>
        </tr>

        <?php
        $allBooksResult = getAllBooks();
        while($bookRow = mysqli_fetch_assoc($allBooksResult)){
        ?>
        <tr>
          <td><?= $bookRow['id'] ?></td>
          <td><?= htmlspecialchars($bookRow['title']) ?></td>
          <td><?= htmlspecialchars($bookRow['author']) ?></td>
          <td><?= htmlspecialchars($bookRow['category']) ?></td>
          <td><?= $bookRow['total_copies'] ?></td>
          <td><?= $bookRow['available_copies'] ?></td>
          <td>
            <a href="editbook.php?id=<?= $bookRow['id'] ?>">Edit</a> |
            <a href="../../controllers/bookDelete.php?id=<?= $bookRow['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>

  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
