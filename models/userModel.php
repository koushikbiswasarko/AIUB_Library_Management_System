<?php
require_once('db.php');

function login($user){
    $databaseConnection = getConnection();

    $userName = trim($user['username'] ?? "");
    $userPassword = trim($user['password'] ?? "");

    if ($userName === "" || $userPassword === "") {
        return false;
    }

    $sqlQuery = "SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);

    mysqli_stmt_bind_param($statement, "ss", $userName, $userPassword);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) === 1) {
        $userData = mysqli_fetch_assoc($result);
        mysqli_stmt_close($statement);
        return $userData;
    }

    mysqli_stmt_close($statement);
    return false;
}

function getAllStudents(){
    $databaseConnection = getConnection();

    $sqlQuery = "SELECT id, username FROM users WHERE role = 'student' ORDER BY username ASC";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function isUsernameTaken($username){
    $databaseConnection = getConnection();
    $userName = trim($username ?? "");

    if ($userName === "") {
        return true;
    }

    $sqlQuery = "SELECT id FROM users WHERE username = ? LIMIT 1";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);
    mysqli_stmt_bind_param($statement, "s", $userName);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    $isTaken = ($result && mysqli_num_rows($result) > 0);
    mysqli_stmt_close($statement);
    return $isTaken;
}

function createUser($username, $password, $role){
    $databaseConnection = getConnection();

    $userName = trim($username ?? "");
    $userPassword = trim($password ?? "");
    $userRole = trim($role ?? "student");

    if ($userName === "" || $userPassword === "") {
        return false;
    }

    // Only allow safe roles (keeps project simple)
    $allowedRoles = ['student', 'librarian', 'admin'];
    if (!in_array($userRole, $allowedRoles, true)) {
        $userRole = 'student';
    }

    $sqlQuery = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);
    mysqli_stmt_bind_param($statement, "sss", $userName, $userPassword, $userRole);
    $ok = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    return $ok;
}

function updatePasswordByUsername($username, $newPassword){
    $databaseConnection = getConnection();
    $userName = trim($username ?? "");
    $password = trim($newPassword ?? "");

    if ($userName === "" || $password === "") {
        return false;
    }

    $sqlQuery = "UPDATE users SET password = ? WHERE username = ?";
    $statement = mysqli_prepare($databaseConnection, $sqlQuery);
    mysqli_stmt_bind_param($statement, "ss", $password, $userName);
    $ok = mysqli_stmt_execute($statement);
    $affected = mysqli_stmt_affected_rows($statement);
    mysqli_stmt_close($statement);

    return ($ok && $affected > 0);
}
?>
