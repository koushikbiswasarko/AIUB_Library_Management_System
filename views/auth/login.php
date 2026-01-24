<?php
session_start();

if(isset($_SESSION['login_error'])){
  $msg = $_SESSION['login_error'];
  unset($_SESSION['login_error']);
}

if(isset($_SESSION['signup_success'])){
    $success_msg = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
}

require_once('../partials/header.php');
?>

<div class="box login-wrap" >
  <h2 class="login-title">Login</h2>

  <?php if(isset($msg)){ ?>
    <div class="msg msg-error"><?php echo $msg; ?></div>
  <?php } ?>

  <?php if(isset($success_msg)){ ?>
    <div class="msg msg-success"><?php echo $success_msg; ?></div>
  <?php } ?>

  <form method="post" action="../../controllers/loginCheck.php">
    <label>Username</label>
    <input type="text" name="username" required>
    <br><br>

    <label>Password</label>
    <input type="password" name="password" required>
    <br><br>

    <button class="inline-btn" type="submit" name="submit">Login</button>
  </form>

  <div class="small-text">
    <a href="signup.php">Create new account</a>
  </div>
</div>

<?php require_once('../partials/footer.php'); ?>
