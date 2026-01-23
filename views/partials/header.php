<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>AIUB Library Management System</title>
  <!-- Keep this path consistent with your XAMPP folder name inside htdocs -->
  <link rel="stylesheet" href="/AIUB_Library_Management_System/assets/css/style.css">
</head>
<body>

<div class="top">
  <b>AIUB Library Management System</b>

  <?php if(isset($_SESSION['username'])){ ?>
    <span style="float:right;">
      <?= $_SESSION['username'] ?> (<?= $_SESSION['role'] ?>)
      | <a href="/AIUB_Library_Management_System/controllers/logout.php" style="color:white;">Logout</a>
    </span>
  <?php } ?>
</div>

<div class="container">
