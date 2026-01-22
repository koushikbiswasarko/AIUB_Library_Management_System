<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <form method="post" action="../../controllers/loginCheck.php">
        <fieldset>
            <legend>Login</legend>

            Username: <input type="text" name="username" value="" /> <br><br>
            Password: <input type="password" name="password" value="" /> <br><br>

            <input type="submit" name="submit" value="Login" />
        </fieldset>

        <p>
            Admin: admin / admin123 <br>
            Librarian: librarian / lib123 <br>
            Student: student / stu123
        </p>
    </form>
</body>
</html>
