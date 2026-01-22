<?php
session_start();
setcookie('status','true',time()-10,'/');
session_destroy();
header('location: ../views/auth/login.php');
?>
