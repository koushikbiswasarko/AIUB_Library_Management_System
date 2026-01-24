<?php
session_start();

if(isset($_SESSION['signup_error'])){
  $msg = $_SESSION['signup_error'];
  unset($_SESSION['signup_error']);
}

require_once('../partials/header.php');
?>

<div class="box login-wrap">
  <h2 class="login-title">Signup</h2>

  <?php if(isset($msg)){ ?>
    <div class="msg msg-error"><?php echo $msg; ?></div>
  <?php } ?>

  <form method="post" action="../../controllers/signupCheck.php">
    <label>Username</label>
    <input type="text" name="username" required>
    <br><br>

    <label>Email</label>
    <input type="email" name="email" required>
    <br><br>

    <label>Password</label>
    <input type="password" name="password" required>
    <br><br>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>
    <br><br>

    <button class="inline-btn" type="submit" name="submit">Create Account</button>
  </form>

  <div class="small-text">
    Already have an account? <a href="login.php">Login</a>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
