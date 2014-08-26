<?php
session_start();
?>

<div style='text-align: center'>
<?php

//This will start a session


$page_title = "Login/Register";
include_once "view/header.php";

if (isset($_SESSION['username']) && isset($_SESSION['password'])){
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
}

//Check do we have username and password

if(!isset($username) && !isset($password)){

echo "Welcome Guest! <br> <a href=login.php><button type='button'>Login</button></a> | <a href=register.php><button type='button'>Register</button></a>";

}else{

echo "<h2>Welcome, ".$username. "<h2>";
echo "<br />";
echo "Please <a href=logout.php><button type='button'>Logout</button></a> OR Continue on our <a href=website.php><button type='button'>Main Page</button></a>";
}
include_once "view/footer.php";
?>
</div>