<?php

//This will start a session

session_start();

include "view/header.php";

$username = $_SESSION['username'];

$password = $_SESSION['password'];


//Check do we have username and password

if(!$username && !$password){

echo "Welcome Guest! <br> <a href=login.php>Login</a> | <a href=register.php>Register</a>";

}else{

echo "Welcome ".$username." (<a href=logout.php>Logout</a>)";
include 'index1.php';
}
include "view/footer.php";
?>
