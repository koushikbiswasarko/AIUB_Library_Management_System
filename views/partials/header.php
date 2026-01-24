<?php
if(session_status() === PHP_SESSION_NONE){
  session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>AIUB Library Management System</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<div class="top">
  <b>AIUB Library Management System</b>

  <?php if(isset($_SESSION['username'])){ ?>
    <span style="float:right;">
      <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)
      | <a href="../../controllers/logout.php" style="color:white;">Logout</a>
    </span>
  <?php } ?>
</div>

<div class="container">
