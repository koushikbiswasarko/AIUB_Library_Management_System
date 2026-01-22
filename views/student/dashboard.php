<?php
require_once('../../controllers/authCheck.php');
?>
<!DOCTYPE html>
<html>
<head><title>Student Dashboard</title></head>
<body>
    <h2>Student Dashboard</h2>
    Welcome, <?=$_SESSION['username']?> (<?=$_SESSION['role']?>)
    <br><br>
    <a href="../../controllers/logout.php">Logout</a>
</body>
</html>
