<?php
    //This will start a session
    if (session_status() == PHP_SESSION_NONE) {
        
        session_start();
    }

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Login Page";
    include "view/header.php";

    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        
        //To distroy the session
        session_destroy();
    }
    
    //Check for the database connection
    require("connect.php");

    //Create a varible to display the login form.
    $form = "<div class='login-card'>
                <h1>Admin Log-in</h1><br>
                <form action='adminlogin.php' method='post'>
                    <input type='text' name='username' placeholder='Username'>
                    <input type='password' name='password' placeholder='Password'>
                    <input type='submit' name='loginbutton' class='login login-submit' value='Login'>
                </form>

                <div class='login-help'>
                <a href='forgotpass.php'>Forgot Password</a> • <a href='login.php'>Cancel</a>
                </div>
            </div>";
     
    //This if statement will run if the login button is pressed.
    if (isset($_POST['loginbutton'])){

        //Get the entered username from the form.
        $username = $_REQUEST['username'];

        //Get the entered password from the form.
        $password = $_REQUEST['password'];

        //Check if the entered username is not empty.
        if ($username != NULL){

            //Check if the entered password is not empty.
            if ($password != NULL){

                //Check if entered data matches our database record.
                $result = mysql_query("SELECT * FROM adminusers WHERE username='$username'");
                $row = mysql_fetch_array($result);
                $id = $row['id'];

                $select_user = mysql_query("SELECT * FROM adminusers WHERE id='$id'");
                $row2 = mysql_fetch_array($select_user);
                $user = $row2['username'];

                //Check if the entered username matches the username in our database system.
                if($username != $user){

                    echo "<script type='text/javascript'>alert('Your ADMIN USERNAME is incorrect!')</script>";
                    echo $form;
                    exit();
                }

                $pass_check = mysql_query("SELECT * FROM adminusers WHERE username='$username' AND id='$id'");
                $row3 = mysql_fetch_array($pass_check);
                $email = $row3['email'];
                
                $select_pass = mysql_query("SELECT * FROM adminusers WHERE username='$username' AND id='$id' AND email='$email'");
                $row4 = mysql_fetch_array($select_pass);
                $real_password = $row4['password'];

                //Check if the entered password matches the associated username in our database.
                if($password != $real_password){
                    echo "<script type='text/javascript'>alert('You must enter the correct PASSWORD.')</script>";
                    echo $form;
                    exit();
                }

                //Now if everything is correct let's finish his/her/its login
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                include 'adminpanel.php';
            }
            else{
                echo "<script type='text/javascript'>alert('You must enter your PASSWORD.')</script>";
                echo $form;
            }
        }
        else{
            echo "<script type='text/javascript'>alert('You must enter your USERNAME.')</script>";
            echo $form;
        }
    }
    else{
        echo $form;
    }
  
    include "view/footer.php";
?>