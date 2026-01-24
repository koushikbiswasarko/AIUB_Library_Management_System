<?php
require_once('../../controllers/roleCheck.php');
requireRole('librarian');

require_once('../../models/db.php');

$conn = getConnection();

$students = mysqli_query($conn, "SELECT id, username FROM users WHERE role='student' ORDER BY username ASC");
$booksForSelect = mysqli_query($conn, "SELECT id, title, author, category, total_copies, available_copies FROM books ORDER BY title ASC");

$allBooks = mysqli_query($conn, "SELECT id, title, author, category, total_copies, available_copies FROM books ORDER BY title ASC");

require_once('../partials/header.php');
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/librarianMenu.php'); ?>
  </div>

  <div style="flex:1;">
    <div class="box">
      <h2>Available Books</h2>
      <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Total</th>
          <th>Available</th>
        </tr>

        <?php while($b = mysqli_fetch_assoc($allBooks)){ ?>
        <tr>
          <td><?php echo htmlspecialchars($b['title']); ?></td>
          <td><?php echo htmlspecialchars($b['author']); ?></td>
          <td><?php echo htmlspecialchars($b['category']); ?></td>
          <td><?php echo $b['total_copies']; ?></td>
          <td><?php echo $b['available_copies']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>

    <div class="box">
      <h3>Issue Form</h3>

      <form method="post" action="../../controllers/issueCheck.php">
        <label style="padding:5px">Student</label>
        <select name="user_id" required style="width:20%; padding:8px;">
          <?php while($s = mysqli_fetch_assoc($students)){ ?>
            <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['username']); ?></option>
          <?php } ?>
        </select>
        <label style="padding:5px">Book</label>
        <select name="book_id" required style="width:40%; padding:8px;">
          <?php while($bk = mysqli_fetch_assoc($booksForSelect)){ ?>
            <option value="<?php echo $bk['id']; ?>">
              <?php echo htmlspecialchars($bk['title']); ?> (Available: <?php echo $bk['available_copies']; ?>)
            </option>
          <?php } ?>
        </select>
        <label style="padding:5px"> Due Date</label>
        <input type="date" name="due_date" required style="width:15%; padding:8px;">
        <br><br>

        <button type="submit" name="submit">Issue</button>
      </form>
    </div>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
