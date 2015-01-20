<?php
    //This will start a session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Admin panel";
    include_once "view/header.php";
    
    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }

    //If no user is logged in then display the main login page.
    if(!isset($username) && !isset($password)){
        echo "<div class='login-card'>
                <div class='login-help'> <h1>Welcome, guest<h1> <br />
                <a href='login.php'>Login</a> • <a href='Register.php'>Register</a>
                </div>
            </div>";
        exit();
    }
    else{
        echo "<div class='login-card'>
                 <p>Welcome, <font color='red'>".$username."</font>
                    <div class='login-help'>
                        <a href='logout.php'>Logout</a>
                    </div>
                  
                    <form action='adminadduser.php' method='post'>     
                        <input type='submit' class='login login-submit' value='Add User'> 
                    </form>
                    
                    <form>
                        <input type='submit' class='login login-submit' value='Delete User'>
                    </form>
                    
                    <form action='adminresetpass.php' method='post'>
                        <input type='submit' class='login login-submit' value='Reset Pass'>
                    </form>
                    
                    <form>
                        <input type='submit' class='login login-submit' value='Find Username'>
                    </form>
                    
                    <form action='website.php' method='post'> 
                        <input type='submit' class='login login-submit' value='Go to Website'>
                    </form>
            
            </div>";     
    }
    ?>
