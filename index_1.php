<?php
include "view/header.php";

//This will start a session
session_start();
require('connect.php');

if (isset($_SESSION['username']) && isset($_SESSION['password'])){
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    echo "Welcome ".$username." (<a href=logout.php>Logout</a>)";
} else {
    echo "Welcome Guest! <br> <a href=login.php>Login</a> | <a href=register.php>Register</a>";
}

include "view/footer.php";
?>