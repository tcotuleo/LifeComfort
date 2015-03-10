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
    
    echo "<div style='text-align: center'>";

    //Create a varible to display the register form.
    $form = "<div class='login-card'>
                <h1>Delete User</h1><br>
                <form action='admindeleteuser.php' method='post'>
                    <input type='text' name='user' placeholder='Username'>
                    <input type='submit' name='delbtn' class='login login-submit' value='Find User'>
                </form>

                <div class='login-help'>
                    <a href='adminpanel.php'>Go back</a>
                </div>
            </div>";
    
    //This if statement will run if the register button is pressed.
    if (isset($_POST['delbtn'])){
        
        //Get the entered username
        $getuser = $_POST['user'];
       
        
        //Check if the username is entered.
        if ($getuser){
            
            
                            
                            {
                                
                                //Check for the database connection
                                require("connect.php");
                                
                                //Check if the entered username matches any record in our database.
                                $query = mysql_query("SELECT id,username,email FROM users WHERE username like ('%$getuser%')");
                                $numrows = mysql_num_rows($query);
                                $res = mysql_query("SELECT id,username,email FROM users WHERE username like ('%$getuser%')");
                                if ($numrows == 0)
                                    {
                                    
                                        echo "<script type='text/javascript'>alert('No records were found..')</script>";
                                        echo $form;
                                      
                                    }
                                    else
                                        {
                                        echo "<div class='login-card'>
                                            <h1>User List</h1>
                                                <table border='0'>
                                                <body>
                                                <tr>
                                                <th><h4>ID No.</h4></th>
                                                <th><h4>Username</h4></th>
                                                <th><h4>Email</h4></th>
                                                <th><h4></h4></th>
                                                </tr>";
                                       while($rows = mysql_fetch_assoc($res))
                                        {
                                            echo "<tr>"
                                            ."<td>".$rows[id]."</td>"
                                            . "<td>".$rows[username]."</td>"
                                            . "<td>".$rows[email]."</td>"
                                                    ."<td><a href=delete.php?id=".$rows[id].">Delete</a>"
                                               . "</tr>";
                                                    
                                        }
                                        
                                        echo "</body></table><div class='login-help'><a href='adminpanel.php'>Go back</a></div></div>";
                                        
                                }
                                
                                    
                                mysql_close();
                            }
                            
        }
        
    }
    else{
        echo $form;
    }
    }
include "view/footer.php";

?> 
