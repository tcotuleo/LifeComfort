<?php
error_reporting(E_ALL ^ E_NOTICE);
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div></div>
        <?php
        if ($_POST['registerbtn']){
            $getuser = $_POST['user'];
            $getemail = $_POST['email'];
            $getpass = $_POST['pass'];
            $getretypepass = $_POST['retypepass'];
            
            if ($getuser){
                if ($getemail){
                    if ($getpass){
                        if ($getretypepass){
                            if ($getpass === $getretypepass){
                                if ( (strlen($getemail) >= 7) && (strstr ($getemail,"@")) && (strstr ($getemail,"."))){
                                    require("connect.php");
                                    
                                    $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                    $numrows = mysql_num_rows($query);
                                    if ($numrows == 0){
                                        $query = mysql_query("SELECT * FROM users WHERE username='$getemail'");
                                        $numrows = mysql_num_rows($query);
                                        if ($numrows == 0){
                                            
                                            $password = md5(md5("kjfiufj".$password."Fj56fj"));
                                            date_default_timezone_set('UTC');
                                            $date = date("F d, Y");
                                            $code = md5(rand());
                                            
                                            mysql_query("INSERT INTO users VALUES ('', '$getuser', '$password', '$getemail', '0', '$code', '$date')");
                                            
                                            $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                            $numrows = mysql_num_rows($query);
                                            if ($numrows == 1){
                                                
                                                $site = "http://localhost:8000";
                                                $webmaster = "admin@lifecomfort.com";
                                                $headers = "From: $webmaster";
                                                $subject = "Activate your account";
                                                $message = "Thanks for registering. Click the link below to activte your account.\n";
                                                $message .= "$site/activate.php?user=$getuser&code=$code\n";
                                                $message .= "You must activate your account to login";
                                                
                                                if (mail($getemail, $subject, $message, $headers)){
                                                    $errormsg = "You have been registered. You must activate your account from the activation link sent to <b>$getemail</b>.";
                                                    $getuser = "";
                                                    $getemail = "";
                                                    
                                                }
                                                
                                                else{
                                                    $errormsg = "An error has occured. Your activation email was not sent.";
                                                }
                                                
                                                
                                            }else{
                                                $errormsg = "An error has occured. Your account was not created.";
                                            }
                                        
                                        }
                                        else{
                                        $errormsg = "The user already exists with the same username";
                                        }
                                        
                                    }
                                    else{
                                        $errormsg = "The user already exists with the same email";
                                    }
                                    
                                    mysql_close();
                                }
                                else{
                                    $errormsg = "You must enter a valid email address to register";
                                }
                            }
                            else{
                                $errormsg = "Your password did not match.";
                            }
                        }
                        else{
                            $errormsg = "You must retype your password to register.";
                            }
                    }
                    else{
                    $errormsg = "You must enter your password to register.";
                    }
                }
                else{
                    $errormsg = "You must enter your email to register.";
                }
            }
            else{
                $errormsg = "You must enter your username to register.";
            }
        }

          
        $form = "<form action='register.php' method='post'> "
                . "<table> "
                . "<tr> "
                . "<td></td> "
                . "<td><font color='red'>$errormsg</font></td> "
                . "</tr>"
                . "<tr> "
                . "<td> Username: </td> "
                . "<td> <input type='text' name='user' value='$getuser' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Email: </td> "
                . "<td> <input type='text' name='email' value='$getemail' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Password: </td> "
                . "<td> <input type='password' name='pass' value='' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Retype: </td> "
                . "<td> <input type='password' name='retypepass' value='' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td></td> "
                . "<td> <input type='submit' name='registerbtn' value='Register' /> </td> "
                . "</tr> "
                . "</table> "
                . "</form>";
        
        echo $form;
        
            
        ?>
        
    </body>
</html>

