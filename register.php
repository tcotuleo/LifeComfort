<?php
include "view/header.php";


$form = "<form action='register.php' method='post'> "
                . "<table algin='center'> "
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
                                            
                                            //$password = md5(md5("kjfiufj".$password."Fj56fj"));
                                            date_default_timezone_set('UTC');
                                            $date = date("F d, Y");
                                            
                                            
                                            mysql_query("INSERT INTO users (username, password, email) VALUES ('$getuser', '$getpass', '$getemail')");
                                            
                                            $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                            $numrows = mysql_num_rows($query);
                                            if ($numrows == 1){
                                                
                                                echo $getuser.", you are now registered. Thank you!<br><a href=login.php>Login</a>";
                                                
                                                
                                            }else{
                                                echo "An error has occured. Your account was not created.";
                                            }
                                        
                                        }
                                        else{
                                        echo "The user already exists with the same username. $form";
                                        }
                                        
                                    }
                                    else{
                                        echo "The user already exists with the same email. $form";
                                    }
                                    
                                    mysql_close();
                                }
                                else{
                                    echo "You must enter a valid email address to register. $form";
                                }
                            }
                            else{
                                echo "Your password did not match. $form";
                            }
                        }
                        else{
                            echo "You must retype your password to register. $form";
                            }
                    }
                    else{
                    echo "You must enter your password to register. $form";
                    }
                }
                else{
                    echo "You must enter your email to register. $form";
                }
            }
            else{
                echo "You must enter your username to register. $form";
            }
        }else{
        
        echo $form;
        
        } 
include "view/footer.php";

?> 