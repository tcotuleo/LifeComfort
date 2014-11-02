<?php
    //This will start a session
    session_start();
    
    //Align all text to center
    //echo "<div style='text-align: center'>";
    
    $page_title = "Login/Register";
    //include_once "view/header.php";
    
    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }

    //If no user is logged in than display the main login page.
    if(!isset($username) && !isset($password)){
        
        include "login.php";
        //echo "<h3>Welcome Guest! </h3><br> <a href=login.php><button type='button'>Login</button></a> | "
            //. "<a href=register.php><button type='button'>Register</button></a>";

    }
    //If no user logged in, Login and Register options are avaliable.
    else{

        include_once "view/header.php";
        echo "<div class='login-card'>
        <div class='login-help'> <h1>Welcome, ".$username. "<h1> <br />
            <a href='logout.php'>Logout</a> • <a href='website.php'>Main Page</a>
        </div>
    </div>";

    }
    
    include_once "view/footer.php";
?>