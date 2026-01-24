<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/userModel.php');
$msg = $_SESSION['user_error'] ?? "";
unset($_SESSION['user_error']);
$successMsg = $_SESSION['user_success'] ?? "";
unset($_SESSION['user_success']);
require_once('../partials/header.php');
?>


<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">

    <div class="box">
      <h2>Manage Users</h2>

      <form method="post" action="../../controllers/userAdd.php">
        <label>Username:</label>
        <input type="text" name="username" required style="width:34%;">

        <label>Email:</label>
        <input type="email" name="email" required style="width:47%;">

        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required style="width:34%;">

        <label>Role:</label>
        <select name="role" required style="width:50%;">
          <option value="student">student</option>
          <option value="librarian">librarian</option>
          <option value="admin">admin</option>
        </select>
        <br><br>

        <button type="submit" name="submit">Add User</button>
      </form>
    </div>
    
    <?php if($msg != ""){ ?>
      <div class="msg msg-error"><?php echo $msg; ?></div>
    <?php } ?>

    <?php if($successMsg != ""){ ?>
      <div class="msg msg-success"><?php echo $successMsg; ?></div>
    <?php } ?>

    <div class="box">
      <h3>User List</h3>

      <table>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Delete</th>
        </tr>

        <?php
        $r = getAllUsers();
        while($u = mysqli_fetch_assoc($r)){
        ?>
        <tr>
          <td><?php echo htmlspecialchars($u['username']); ?></td>
          <td><?php echo htmlspecialchars($u['email']); ?></td>
          <td>
            <form method="post" action="../../controllers/userRoleUpdate.php">
              <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
              <select name="role">
                <option value="student" <?php if($u['role']=="student") echo "selected"; ?>>student</option>
                <option value="librarian" <?php if($u['role']=="librarian") echo "selected"; ?>>librarian</option>
                <option value="admin" <?php if($u['role']=="admin") echo "selected"; ?>>admin</option>
              </select>
              <br><br>
              <button type="submit" name="submit">Update</button>
            </form>
          </td>
          <td>
            <deletebutton 
            onclick="if(confirm('&#9888; Warning: Are you sure you want to delete this user? This action cannot be undone.')) 
            {
              window.location.href='../../controllers/userDelete.php?id=<?php echo $u['id']; ?>';
            }">Delete</deletebutton>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>

  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
