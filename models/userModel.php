<?php
require_once('db.php');

function login($user){
    $conn = getConnection();

    $username = $user['username'];
    $password = $user['password'];

    if($username == "" || $password == ""){
        return false;
    }

    $sql = "SELECT * FROM users 
            WHERE BINARY username = '$username' AND BINARY password = '$password'";

    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) == 1){
        return mysqli_fetch_assoc($result);
    }

    return false;
}

function getAllStudents(){
    $conn = getConnection();
    $sql = "SELECT id, username FROM users
            WHERE role='student'
            ORDER BY username ASC";
    return mysqli_query($conn, $sql);
}

function getAllUsers(){
    $conn = getConnection();
    $sql = "SELECT id, username, email, role FROM users
            ORDER BY role DESC";
    return mysqli_query($conn, $sql);
}

function isUsernameTaken($username){
    $conn = getConnection();

    if($username == ""){
        return true;
    }

    $sql = "SELECT id FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0){
        return true;
    }

    return false;
}

function isUserEmailTaken($email){
    $conn = getConnection();

    if($email == ""){
        return true;
    }

    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0){
        return true;
    }

    return false;
}

function createUser($username, $password, $email, $role){
    $conn = getConnection();

    if($username == "" || $password == ""){
        return false;
    }

    if($role == ""){
        $role = "student";
    }

    $sql = "INSERT INTO users (username, password, email, role)
            VALUES ('$username', '$password', '$email', '$role')";

    return mysqli_query($conn, $sql);
}

function deleteUser($userId){
    $conn = getConnection();

    $id = (int)$userId;
    if($id <= 0){
        return false;
    }

    $sql = "DELETE FROM users WHERE id=$id";
    return mysqli_query($conn, $sql);
}

function updateUserRole($userId, $newRole){
    $conn = getConnection();

    $id = (int)$userId;
    if($id <= 0 || $newRole == ""){
        return false;
    }

    $sql = "UPDATE users
            SET role='$newRole'
            WHERE id=$id";

    return mysqli_query($conn, $sql);
}
?>
