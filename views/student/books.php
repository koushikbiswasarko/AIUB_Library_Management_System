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
      <input type="text" id="search" placeholder="Search by title, author, or category" style="width: 75%; padding:8px">
    </div>

    <div class="box">
      <table>
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Available</th>
          </tr>
        </thead>

        <tbody id="bookTable">
          <?php
          $allBooksResult = getAllBooks();
          while ($bookRow = mysqli_fetch_assoc($allBooksResult)) {
          ?>
            <tr>
              <td><?php echo htmlspecialchars($bookRow['title']); ?></td>
              <td><?php echo htmlspecialchars($bookRow['author']); ?></td>
              <td><?php echo htmlspecialchars($bookRow['category']); ?></td>
              <td><?php echo $bookRow['available_copies']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.getElementById("search").addEventListener("keyup", function () {
    var keyword = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../../controllers/searchBook.php?keyword=" + keyword, true);

    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById("bookTable").innerHTML = this.responseText;
        }
    };

    xhr.send();
});
</script>

<?php require_once('../partials/footer.php'); ?>
