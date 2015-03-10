<?php
    //This will start a session
    if (session_status() == PHP_SESSION_NONE) 
        {
        session_start();
        }
    
    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Admin add user";
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
    else
        {
        //Create a varible to display the register form.
        $form = "<div class='login-card'>
                    <h1>Add a User</h1><br>
                    <form action='register.php' method='post'>
                        <input type='text' name='user' placeholder='Username'>
                        <input type='text' name='email' placeholder='Email'>
                        <input type='password' name='pass' placeholder='Password'>
                        <input type='password' name='retypepass' placeholder='Re-type Password'>
                        <input type='submit' name='registerbtn' class='login login-submit' value='Register'>
                    </form>

                    <div class='login-help'>
                        <a href='adminpanel.php'>Go back</a>
                    </div>
                </div>";
    
        //This if statement will run if the register button is pressed.
        if (isset($_POST['registerbtn'])){

            //Get the entered username
            $getuser = $_POST['user'];

            //Get the entered email address
            $getemail = $_POST['email'];

            //Get the entered password
            $getpass = $_POST['pass'];

            //Get the retyped password
            $getretypepass = $_POST['retypepass'];

            //Check if the username is entered.
            if ($getuser){

                //Check if the email is entered.
                if ($getemail){

                    //Check if the password is entered.
                    if ($getpass){

                        //Check if the password is retyped or not.
                        if ($getretypepass){

                            //Check if the password matches the retyped password.
                            if ($getpass === $getretypepass){

                                //Check if the entered email address is valid.
                                if ( (strlen($getemail) >= 7) && (strstr ($getemail,"@")) && (strstr ($getemail,"."))){

                                    //Check for the database connection
                                    require("connect.php");

                                    //Check if the entered username matches any record in our database.
                                    $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                    $numrows = mysql_num_rows($query);
                                    if ($numrows == 0){

                                        //Check if the entered email matched any record in our database.
                                        $query = mysql_query("SELECT * FROM users WHERE email='$getemail'");
                                        $numrows = mysql_num_rows($query);
                                        if ($numrows == 0){

                                            //If everything is correct, enter the user into our database and register that user.
                                            mysql_query("INSERT INTO users (username, password, email) VALUES ('$getuser', '$getpass', '$getemail')");

                                            //Check if the user was registered or not.
                                            $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                            $numrows = mysql_num_rows($query);
                                            if ($numrows == 1){

                                                echo "<h3>".$getuser.", you are now registered. Thank you!<br></h3>";
                                                echo "<p><a href='login.php'>Click here to log in.</a></p>";                                           

                                            }else{
                                                echo "<script type='text/javascript'>alert('An error has occurred. Your account was not created.')</script>";
                                            }

                                        }
                                        else{
                                            echo "<script type='text/javascript'>alert('That USERNAME already exists.')</script>";
                                            echo $form;
                                        }

                                    }
                                    else{
                                        echo "<script type='text/javascript'>alert('A username already exists with that EMAIL address.')</script>";
                                        echo $form;
                                    }

                                    mysql_close();
                                }
                                else{
                                    echo "<script type='text/javascript'>alert('You must enter a valid EMAIL address to register.')</script>";
                                    echo $form;
                                }
                            }
                            else{
                                echo "<script type='text/javascript'>alert('Your retyped PASSWORD did not match')</script>";
                                echo $form;
                            }
                        }
                        else{
                            echo "<script type='text/javascript'>alert('You must retype your PASSWORD to register')</script>";
                            echo $form;
                        }
                    }
                    else{
                        echo "<script type='text/javascript'>alert('You must enter your PASSWORD to register')</script>";
                        echo $form;
                    }
                }
                else{
                    echo "<script type='text/javascript'>alert('You must enter your EMAIL to register')</script>";
                    echo $form;
                }
            }
            else{
                echo "<script type='text/javascript'>alert('You must enter your USERNAME to register')</script>";
                echo $form;
            }
        }
        else{
            echo $form;
        } 
    }
include "view/footer.php";

?> 
