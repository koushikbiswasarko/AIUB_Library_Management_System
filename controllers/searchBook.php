<?php
require_once('../models/db.php');

$conn = getConnection();

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$sql = "
    SELECT * FROM books
    WHERE title LIKE '%$keyword%'
       OR author LIKE '%$keyword%'
       OR category LIKE '%$keyword%'
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
  <td><?php echo htmlspecialchars($row['title']); ?></td>
  <td><?php echo htmlspecialchars($row['author']); ?></td>
  <td><?php echo htmlspecialchars($row['category']); ?></td>
  <td><?php echo $row['available_copies']; ?></td>
</tr>
<?php
}
