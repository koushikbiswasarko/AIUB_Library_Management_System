<?php
require_once('db.php');

// NOTE (for WebTech class):
// This project uses simple mysqli_query() (no bind_param / prepared statements)
// because many course templates don't cover prepared statements yet.

function login($user){
    $databaseConnection = getConnection();

    $userName = trim($user['username'] ?? "");
    $userPassword = trim($user['password'] ?? "");

    if ($userName === "" || $userPassword === "") {
        return false;
    }

    $safeUserName = mysqli_real_escape_string($databaseConnection, $userName);
    $safePassword = mysqli_real_escape_string($databaseConnection, $userPassword);

    $sqlQuery = "SELECT * FROM users WHERE username='$safeUserName' AND password='$safePassword' LIMIT 1";
    $result = mysqli_query($databaseConnection, $sqlQuery);

    if ($result && mysqli_num_rows($result) === 1) {
        return mysqli_fetch_assoc($result);
    }

    return false;
}

function getAllStudents(){
    $databaseConnection = getConnection();
    $sqlQuery = "SELECT id, username FROM users WHERE role='student' ORDER BY username ASC";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function getAllUsers(){
    $databaseConnection = getConnection();
    $sqlQuery = "SELECT id, username, email, role FROM users ORDER BY id DESC";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function isUsernameTaken($username){
    $databaseConnection = getConnection();
    $userName = trim($username ?? "");

    if ($userName === "") {
        return true;
    }

    $safeUserName = mysqli_real_escape_string($databaseConnection, $userName);
    $sqlQuery = "SELECT id FROM users WHERE username='$safeUserName' LIMIT 1";
    $result = mysqli_query($databaseConnection, $sqlQuery);

    return ($result && mysqli_num_rows($result) > 0);
}

function createUser($username, $password, $email, $role){
    $databaseConnection = getConnection();

    $userName = trim($username ?? "");
    $userPassword = trim($password ?? "");
    $userEmail = trim($email ?? "");
    $userRole = trim($role ?? "student");

    if ($userName === "" || $userPassword === "") {
        return false;
    }

    // Only allow safe roles (keeps project simple)
    $allowedRoles = ['student', 'librarian', 'admin'];
    if (!in_array($userRole, $allowedRoles, true)) {
        $userRole = 'student';
    }

    $safeUserName = mysqli_real_escape_string($databaseConnection, $userName);
    $safePassword = mysqli_real_escape_string($databaseConnection, $userPassword);
    $safeEmail = mysqli_real_escape_string($databaseConnection, $userEmail);
    $safeRole = mysqli_real_escape_string($databaseConnection, $userRole);

    // IMPORTANT: Your users table must have an email column.
    $sqlQuery = "INSERT INTO users (username, password, email, role) VALUES ('$safeUserName', '$safePassword', '$safeEmail', '$safeRole')";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function updatePasswordByUsername($username, $newPassword){
    $databaseConnection = getConnection();
    $userName = trim($username ?? "");
    $password = trim($newPassword ?? "");

    if ($userName === "" || $password === "") {
        return false;
    }

    $safeUserName = mysqli_real_escape_string($databaseConnection, $userName);
    $safePassword = mysqli_real_escape_string($databaseConnection, $password);

    $sqlQuery = "UPDATE users SET password='$safePassword' WHERE username='$safeUserName'";
    $ok = mysqli_query($databaseConnection, $sqlQuery);
    $affected = mysqli_affected_rows($databaseConnection);

    return ($ok && $affected > 0);
}

function deleteUserById($userId){
    $databaseConnection = getConnection();
    $id = (int)($userId ?? 0);
    if ($id <= 0) {
        return false;
    }
    $sqlQuery = "DELETE FROM users WHERE id=$id";
    return mysqli_query($databaseConnection, $sqlQuery);
}

function updateUserRoleById($userId, $newRole){
    $databaseConnection = getConnection();

    $id = (int)($userId ?? 0);
    $role = trim($newRole ?? "");
    $allowedRoles = ['student', 'librarian', 'admin'];
    if ($id <= 0 || !in_array($role, $allowedRoles, true)) {
        return false;
    }

    $safeRole = mysqli_real_escape_string($databaseConnection, $role);
    $sqlQuery = "UPDATE users SET role='$safeRole' WHERE id=$id";
    return mysqli_query($databaseConnection, $sqlQuery);
}

?>
