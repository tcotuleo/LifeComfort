<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Forgot Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        if(!$username && !$userid) {
            if ($_POST['resetbtn']){
                
                //Getting the form data.
                $user = $_POST['user'];
                $email = $_POST['email'];
                
                if ($user){
                    if ($email){
                       if ((strlen($email) > 7) && (strstr ($getemail,"@")) && (strstr ($getemail,"."))){
                           //connect the DB.
                           require("connect.php");
                           
                           $query = mysql_query("SELECT * FROM users WHERE username='$user'");
                           $numrows = mysql_num_rows($query);
                           if ($numrows == 1){
                               
                               //Getting info for account.
                               $row = mysql_fetch_assoc($query);
                               $dbemail = $row['email'];
                               
                               //Making sure the email is correct.
                               if ($email == $dbemail){
                                   //Generating the new password.
                                   $pass = rand();
                                   $pass = md5($pass);
                                   $pass = substr($pass, 0, 15);
                                   $password = md5(md5("kjfiufj".$pass."Fj56fj"));
                                            
                                   
                                   //Updating the db with new password.
                                   mysql_query("UPDATE users SET password='$password' WHERE username='$user'");
                                   
                                   //making sure the password was changed.
                                   $query = mysql_query("SELECT * FROM users WHERE username='$user' AND password='$password'");
                                   $numrows = mysql_num_rows($query);
                                   if ($numrows == 1){
                                       
                                        //generating email.
                                       
                                        $webmaster = "admin@lifecomfort.com";
                                        $headers = "From: $webmaster";
                                        $subject = "Your new password";
                                        $message = "Your password has been reset. Your new password is right below.";
                                        $message .= "Password: $pass\n";
                                        
                                        if (mail($email, $subject, $message, $headers)){
                                            
                                            echo "Your password has been reset. You should receive an email shortly.";
                                        }
                                        else{
                                            echo "Error. Your email was not sent with your new password.";
                                        }
                                                
                                       
                                   }
                                   else{
                                       echo "An error has occured and your password was not reset.";
                                   }
                                   
                               }
                               else{
                                   echo "You enter the wrong email address.";
                               }
                               
                               
                           }
                           else{
                               echo "The username was not found.";
                           }
                           
                           mysql_close();
                       }
                       else{
                           echo "Please enter a valid email address.";
                       } 
                    }
                    else{
                        echo "Please enter your email.";
                    }
                }
                else{
                    echo "Please enter you username.";
                }
            }
            
            echo "<form action='forgotpass.php' method='post'> "
                . "<table> "
                . "<tr> "
                . "<td> Username: </td> "
                . "<td> <input type='text' name='user' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Eamil: </td> "
                . "<td> <input type='text' name='email' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td></td> "
                . "<td> <input type='submit' name='resetbtn' value='Reset Password' /> </td> "
                . "</tr> "
                . "</table> "
                . "</form>";
        }
        else{
            echo "Please logout to view this page.";
        }
        
        
        ?>
    </body>
</html>
