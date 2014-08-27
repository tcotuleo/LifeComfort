<?php
    //This will start a session
    session_start();

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
    $form = "<form action='updatepass.php' method='post'> "
        . "<table align='center' width='25%' bordercolor='#D2691E' bgcolor='#A3C1AD'> "
        . "<tr> "
        . "<td> New Password: </td> "
        . "<td> <input type='password' name='pass' value='' /> </td> "
        . "</tr>"
        . "<tr> "
        . "<td> Retype: </td> "
        . "<td> <input type='password' name='retypepass' value='' /> </td> "
        . "</tr>"
        . "</table> "
        . "<input type='submit' name='submitbtn' value='Submit' /> "
        . "<a href=index.php><button type='button'>Cancel</button></a> "
        . "</form>";
    
    if (isset($_POST['submitbtn'])){

        //Get the entered password
        $getnewpass = $_POST['pass'];

        //Get the retyped password that was entered
        $getretypepass = $_POST['retypepass'];

        //Check if the password is entered.
        if ($getnewpass){

            //Check if the password is retyped or not.
            if ($getretypepass){

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
                        echo "<h3>Your password has been changed successfully. Thank you!<br></h3>";
                        echo "<a href=login.php><button type='button'>Login</button></a>";
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
            echo "Please enter your new password below. $form";
        }
    }
?>

