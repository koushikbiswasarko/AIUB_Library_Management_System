<?php
session_start();

$successMessage = $_SESSION['signup_success'] ?? '';
unset($_SESSION['signup_success']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | AIUB Library Management System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/AIUB_Library_Management_System/assets/css/style.css" />
    <style>
        /* Small page-specific tweaks (keeps main CSS simple) */
        .login-wrap{max-width:420px;padding:40px;margin:40px auto;}
        .login-title{margin:0 0 10px 0;}
        .hint{font-size:14px;color:gray;margin-top:10px;}
        .inline-btn{width:auto;padding:10px 16px;}
        .auth-links{margin-top:14px;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;}
        .auth-links a{font-size:14px;text-decoration:none;color:#2e59d9;}
        .auth-links a:hover{text-decoration:underline;}
        .msg{margin:10px 0;padding:10px;border-radius:6px;font-size:14px;}
        .msg-success{background:#e6ffea;border:1px solid #9be7a8;color:#0a6b1a;}
    </style>
</head>
<body>

<div class="top">
    <b>AIUB Library Management System</b>
</div>

<div class="container">
    <div class="box login-wrap">
        <h2 class="login-title">Login</h2>

        <?php if ($successMessage !== '') { ?>
            <div class="msg msg-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php } ?>

        <form method="post" action="../../controllers/loginCheck.php">
            <label>Username</label>
            <input type="text" name="username" value="" required />
            <br><br>

            <label>Password</label>
            <input type="password" name="password" value="" required />
            <br><br>

            <button class="inline-btn" type="submit" name="submit">Login</button>
        </form>

        <div class="auth-links">
            <a href="forgot_password.php">Forgot password?</a>
            <a href="signup.php">Create new account</a>
        </div>

        <!--
        <p class="hint">
            Admin: admin / admin123 <br>
            Librarian: librarian / lib123 <br>
            Student: student / stu123
        </p>
        -->
    </div>
</div>

<div class="footer">
    © <?php echo date('Y'); ?> AIUB Library Management System
</div>

</body>
</html>
