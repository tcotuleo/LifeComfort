<?php
    //This will start a session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $page_title = "Reset password page";
    
    //Check for the database connection
    require("connect.php");

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['email'])){
        $getusername = $_SESSION['username'];
        $getemail = $_SESSION['email'];
    }
    
    //Display the form so that the user can enter the new passowrd.
    
    $form = "<div class='login-card'>
                    <h1>Update Password</h1><br>
                    <form action='updatepass.php' method='post'>
                        <input type='password' name='pass' placeholder='New password'>
                        <input type='password' name='retypepass' placeholder='Re-type password'>
                        <input type='submit' name='submitbtn' class='login login-submit' value='Submit'>
                    </form>

                    <div class='login-help'>
                      <a href='index.php'>Cancel</a>
                    </div>
                </div>";
    
    if (isset($_POST['submitbtn'])){

        //Get the entered password
        if (isset($_POST['pass'])){
        $getnewpass = $_POST['pass'];
        }

        //Get the retyped password that was entered
        if (isset($_POST['retypepass'])) {
        $getretypepass = $_POST['retypepass'];
        }

        //Check if the password is entered.
        if (isset($getnewpass)){

            //Check if the password is retyped or not.
            if (isset($getretypepass)){

                //Check if the password matches the retyped password.
                if ($getnewpass === $getretypepass){
                    
                    //Update the password for the user if the new password matches the retyped password.
                    mysql_query("UPDATE users SET password='$getnewpass' WHERE username='$getusername' AND email='$getemail' ");
                    
                    //Make sure that the new password was updated with associated username.
                    $pass_check = mysql_query("SELECT * FROM users WHERE username='$getusername'");
                    $row3 = mysql_fetch_array($pass_check);
                    $email = $row3['email'];
                    $select_pass = mysql_query("SELECT * FROM users WHERE username='$getusername' AND email='$email'");
                    $row4 = mysql_fetch_array($select_pass);
                    $real_password = $row4['password'];
                    
                    //Display the confirmation message if the password was change.
                    if ($getnewpass === $real_password){
                        include_once "view/header.php";
                        echo "<div class='displaymessage-card'>"
                        . "<p>Your password has been changed successfully. Thank you!</p>"
                        . "<div class='login-help'>
                      <a href='login.php'>Login</a>
                    </div></div>";
                    }
                    else{
                        echo "An error has occured. Your password was not changed successfully.";
                    }
                }
                else{
                    echo "Your <font color='red'>PASSWORD</font> did not match. $form";
                }   
            }
            else{
                echo "You must retype your <font color='red'>PASSWORD</font> to change your password. $form";
            }
        }
        else{
            echo "$form";
        }
        
    }
        
?>

