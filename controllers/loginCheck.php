<?php
session_start();
require_once('../models/userModel.php');

if(isset($_POST['submit'])){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if($username == "" || $password == ""){
        echo "null value!";
    }else{
        $user = ['username'=> $username, 'password'=> $password];
        $u = login($user);

        if($u){
            setcookie('status', 'true', time()+3000, '/');

            // store session like faculty code
            $_SESSION['username'] = $u['username'];
            $_SESSION['role'] = $u['role'];
            $_SESSION['user_id'] = $u['id'];

            // redirect based on role
            if($u['role'] == 'admin'){
                header('location: ../views/admin/dashboard.php');
            }elseif($u['role'] == 'librarian'){
                header('location: ../views/librarian/dashboard.php');
            }else{
                header('location: ../views/student/dashboard.php');
            }
        }else{
            echo "invalid user!";
        }
    }
}else{
    header('location: ../views/auth/login.php');
}
?>
