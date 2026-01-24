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
      <button onclick="location.href='addbook.php'">Add Book</button>
    </div>

    <div class="box">
      <table>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Total</th>
          <th>Available</th>
          <th>Action</th>
        </tr>

        <?php
        $r = getAllBooks();
        while($b = mysqli_fetch_assoc($r)){
        ?>
        <tr>
          <td><?php echo htmlspecialchars($b['title']); ?></td>
          <td><?php echo htmlspecialchars($b['author']); ?></td>
          <td><?php echo htmlspecialchars($b['category']); ?></td>
          <td><?php echo $b['total_copies']; ?></td>
          <td><?php echo $b['available_copies']; ?></td>
          <td>
            <button onclick="location.href='editbook.php?id=<?php echo $b['id']; ?>'">Edit</button>
            <br><br>
            <deletebutton 
            onclick="if(confirm('&#9888; Warning: Are you sure you want to delete this book? This action cannot be undone.')) {
              window.location.href='../../controllers/bookDelete.php?id=<?php echo $b['id']; ?>';
            }">Delete</deletebutton>
            <br><br>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
