<?php
session_start();

$signupError = $_SESSION['signup_error'] ?? '';
unset($_SESSION['signup_error']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup | AIUB Library Management System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/AIUB_Library_Management_System/assets/css/style.css" />
    <style>
        .login-wrap{max-width:420px;margin:40px auto;}
        .login-title{margin:0 0 10px 0;}
        .inline-btn{width:auto;padding:10px 16px;}
        .small-text{margin-top:12px;font-size:14px;}
        .small-text a{text-decoration:none;color:#2e59d9;}
        .small-text a:hover{text-decoration:underline;}
        .msg{margin:10px 0;padding:10px;border-radius:6px;font-size:14px;}
        .msg-error{background:#ffe6e6;border:1px solid #ffb3b3;color:#a80000;}
    </style>
</head>
<body>

<div class="top">
    <b>AIUB Library Management System</b>
</div>

<div class="container">
    <div class="box login-wrap">
        <h2 class="login-title">Signup</h2>

        <?php if ($signupError !== '') { ?>
            <div class="msg msg-error"><?php echo htmlspecialchars($signupError); ?></div>
        <?php } ?>

        <form method="post" action="../../controllers/signupCheck.php">
            <label>Username</label>
            <input type="text" name="username" required />
            <br><br>

            <label>Email</label>
            <input type="email" name="email" required />
            <br><br>

            <label>Password</label>
            <input type="password" name="password" required />
            <br><br>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required />
            <br><br>

            <button class="inline-btn" type="submit" name="submit">Create Account</button>
        </form>

        <div class="small-text">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</div>

<div class="footer">
    © <?php echo date('Y'); ?> AIUB Library Management System
</div>

</body>
</html>
