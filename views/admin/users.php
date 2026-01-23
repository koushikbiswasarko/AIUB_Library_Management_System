<?php
require_once('../../controllers/roleCheck.php');
requireRole('admin');
require_once('../../models/userModel.php');
require_once('../partials/header.php');

$userError = $_SESSION['user_error'] ?? '';
$userSuccess = $_SESSION['user_success'] ?? '';
unset($_SESSION['user_error']);
unset($_SESSION['user_success']);
?>

<div style="display:flex; gap:15px;">
  <div style="width:250px;">
    <?php require_once('../partials/adminMenu.php'); ?>
  </div>

  <div style="flex:1;">

    <div class="box">
      <h2>Manage Users</h2>

      <?php if ($userError !== '') { ?>
        <div style="background:#ffe6e6;border:1px solid #ffb3b3;color:#a80000;padding:10px;border-radius:6px;margin:10px 0;">
          <?php echo htmlspecialchars($userError); ?>
        </div>
      <?php } ?>

      <?php if ($userSuccess !== '') { ?>
        <div style="background:#e6ffea;border:1px solid #b3ffc2;color:#006b1b;padding:10px;border-radius:6px;margin:10px 0;">
          <?php echo htmlspecialchars($userSuccess); ?>
        </div>
      <?php } ?>

      <h3 style="margin-top:15px;">Add New User</h3>
      <form method="post" action="../../controllers/userAddByAdminCheck.php" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;align-items:end;">
        <div>
          <label>Username</label>
          <input type="text" name="username" required>
        </div>
        <br><br>
        <div>
          <label>Email</label>
          <input type="email" name="email" required>
        </div>
        <br><br>
        <div>
          <label>Password</label>
          <input type="password" name="password" required>
        </div>
        <br><br>
        <div>
          <label>Role</label>
          <select name="role" required style="width:100%;padding:10px;border:1px solid #cccccc;border-radius:5px;">
            <option value="student">Student</option>
            <option value="librarian">Librarian</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div style="grid-column:1 / -1;">
          <button class="btn" type="submit" name="submit" style="background-color:#0d6efd;color:white;">+ Add User</button>
        </div>
      </form>
    </div>

    <div class="box">
      <h3>User List</h3>
      <table>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>

        <?php
        $allUsersResult = getAllUsers();
        while($userRow = $allUsersResult ? mysqli_fetch_assoc($allUsersResult) : null){
        ?>
          <tr>
            <td><?php echo $userRow['id']; ?></td>
            <td><?php echo htmlspecialchars($userRow['username']); ?></td>
            <td><?php echo htmlspecialchars($userRow['email'] ?? ''); ?></td>
            <td>
              <form method="post" action="../../controllers/userRoleUpdate.php" style="display:flex;gap:8px;align-items:center;margin:0;">
                <input type="hidden" name="id" value="<?php echo $userRow['id']; ?>">
                <select name="role" style="padding:6px;border:1px solid #cccccc;border-radius:5px;">
                  <option value="student" <?php echo ($userRow['role']==='student')?'selected':''; ?>>student</option>
                  <option value="librarian" <?php echo ($userRow['role']==='librarian')?'selected':''; ?>>librarian</option>
                  <option value="admin" <?php echo ($userRow['role']==='admin')?'selected':''; ?>>admin</option>
                </select>
                <button type="submit" name="submit" style="padding:6px 10px;border:none;border-radius:5px;background:#198754;color:white;cursor:pointer;">Update</button>
              </form>
            </td>
            <td>
              <?php if ((int)$userRow['id'] === (int)($_SESSION['user_id'] ?? 0)) { ?>
                <span style="color:#777;">(You)</span>
              <?php } else { ?>
                <a href="../../controllers/userDelete.php?id=<?php echo $userRow['id']; ?>" onclick="return confirm('Delete this user?')">Delete</a>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>

      </table>
    </div>

  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
