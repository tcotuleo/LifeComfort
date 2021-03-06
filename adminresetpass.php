<?php
    //This will start a session
    session_start();

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Password reset page";
    include_once "view/header.php";

    //Check for the database connection
    require("connect.php");
   
    //Create a varible to display the change password request form.
    $form = "<div class='login-card'>
                <h1>Forgot Password</h1><br>
                <form action='adminresetpass.php' method='post'>
                    <input type='text' name='username' placeholder='Username'>
                    <input type='text' name='email' placeholder='Email'>
                    <input type='password' name='pass' placeholder='New password'>
                    <input type='password' name='retypepass' placeholder='Re-type password'>
                    <input type='submit' name='submitbtn' class='login login-submit' value='Submit'>
                </form>

                <div class='login-help'>
                    <a href='adminpanel.php'>Cancel</a>
                </div>
            </div>";

    //This if statement will run if the login button is pressed.
    if (isset($_POST['submitbtn'])){

        //Get the entered username from the form.
        $getusername = $_POST['username'];

        //Get the entered email address
        $getemail = $_POST['email'];

        //Check if the entered username is not empty.
        if ($getusername != NULL){

            //Check if the entered email is not empty.
            if ($getemail != NULL){

                //Check if entered data matches our database record.
                $result = mysql_query("SELECT * FROM users WHERE username='$getusername'");
                $row = mysql_fetch_array($result);
                $id = $row['id'];

                $select_user = mysql_query("SELECT * FROM users WHERE id='$id'");
                $row2 = mysql_fetch_array($select_user);
                $user = $row2['username'];

                //Check if the entered username matches the username in our database system.
                if($getusername != $user){
                    echo "<script type='text/javascript'>alert('USERNAME is wrong!')</script>";
                    echo $form;
                    exit();
                }

                $pass_check = mysql_query("SELECT * FROM users WHERE username='$getusername' AND id='$id'");
                $row3 = mysql_fetch_array($pass_check);
                $email = $row3['email'];

                //Check if the entered password matches the associated username in our database.
                if($getemail != $email){
                    echo "<script type='text/javascript'>alert('You must enter the correct EMAIL address associated with your username.')</script>";
                    echo $form;
                    exit();
                }
                else{
                    
                    //If entered username and email matches, update the password.           
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
                                    <a href='adminpanel.php'>Go back</a>
                                    </div>
                                    </div>";
                                }
                                else{
                                    echo "<script type='text/javascript'>alert('An error has occured. Your password was not changed successfully.')</script>";
                                }   
                            }
                            else{
                                echo "<script type='text/javascript'>alert('Your <font color='red'>PASSWORD</font> did not match.')</script>";
                                echo $form;
                            }   
                        }
                        else{
                            echo "<script type='text/javascript'>alert('You must retype your <font color='red'>PASSWORD</font> to change your password.')</script>";
                            echo $form;
                        }
                    }
                    else{
                        echo "$form";
                    }
                }             
            }
            else{
                echo "<script type='text/javascript'>alert('You must enter your EMAIL.')</script>";
                echo $form;
            }      
        }
        else{
            echo "<script type='text/javascript'>alert('You must enter your USERNAME.')</script>";
            echo $form;
        }
    }
    //This else statement will run if user didn't enter any data in the change password request form.
    else {
        echo $form;
    }
    include "view/footer.php";
?>