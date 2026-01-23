<?php
require_once('authCheck.php');

function requireRole($requiredRole){
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        die("Access Denied");
    }
}
