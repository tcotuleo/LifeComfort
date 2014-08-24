<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Reset password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div></div>
        <?php
        
        if ($username && $userid){
            if ($_POST['resetpass']){
                //Getting the data from the form.
                $pass = $_POST['pass'];
                $newpass = $_POST['newpass'];
                $confirmpass = $_POST['confirmpass'];
                
                //Making sure that all the data was entered.
                if ($pass){
                    if ($newpasspass){
                        if ($confirmpass){
                            if ($newpass === $confirmpass){
                                $password = md5(md5("kjfiufj".$password."Fj56fj"));
                                
                                require ('connect.php');
                                
                                //make sure the password is correct.
                                $query = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
                                $numrows = mysql_num_rows($query);
                                if ($numrows == 1){
                                    //new password
                                    $newpassword = md5(md5("kjfiufj".$password."Fj56fj"));
                                    
                                    //update the db with new password.
                                    mysql_query("UPDATE users SET password='$newpassword' WHERE username='$username'");
                                    
                                    //making sure the password was changed
                                    $query = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$newpassword'");
                                    $numrows = mysql_num_rows($query);
                                    if ($numrows == 1){
                                        echo "Your password has been set.";
                                    }
                                    else{
                                        echo "an error has occured. Your password was not reset.";
                                    }
                                }
                                else{
                                    echo "Your current password is incorrect.";
                                }
                                
                                mysql_close();
                            }
                            else{
                                echo "Your new password did not match.";
                            }
                        }
                        else{
                            echo "You must confirm your new password.";
                        }
                }
                    else{
                        echo "You must enter your new password.";
                    }
                }
                else{
                    echo "You must enter your current password.";
                }
            }
            
            echo "<form action='resetpass.php' method='post'> "
                . "<table> "
                . "<tr> "
                . "<td> Current Password: </td> "
                . "<td> <input type='text' name='pass' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> New Password: </td> "
                . "<td> <input type='password' name='newpass' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Confirm Password: </td> "
                . "<td> <input type='password' name='confirmpass' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td></td> "
                . "<td> <input type='submit' name='resetpass' value='Reset Password'/> </td> "
                . "</tr>"
            . "</table></form>";
        }
        else{
            echo "Please login to access this page. <a href='login.php'>Login </a>";
        }
        ?>
        
    </body>
</html>


