<?php
    include "view/header.php";
    
    $page_title = "Register Page";
    //Align all text to center
    echo "<div style='text-align: center'>";

    //Create a varible to display the register form.
    $form = "<div class='login-card'>
                <h1>Register</h1><br>
                <form action='register.php' method='post'>
                    <input type='text' name='user' placeholder='Username'>
                    <input type='text' name='email' placeholder='Email'>
                    <input type='password' name='pass' placeholder='Password'>
                    <input type='password' name='retypepass' placeholder='Re-type Password'>
                    <input type='submit' name='registerbtn' class='login login-submit' value='Register'>
                </form>

                <div class='login-help'>
                  <a href='index.php'>Go back</a>
                </div>
            </div>";
    
 //   $form2 = "<form action='register.php' method='post'> "
 //       . "<table align='center' width='25%' bordercolor='#D2691E' bgcolor='#A3C1AD'> "
 //       . "<tr> "
 //       . "<td> Username: </td> "
 //       . "<td> <input type='text' name='user' value='$getuser' /> </td> "
 //       . "</tr>"
 //       . "<tr> "
 //       . "<td> Email: </td> "
 //       . "<td> <input type='text' name='email' value='$getemail' /> </td> "
 //       . "</tr>"
 //       . "<tr> "
 //       . "<td> Password: </td> "
 //       . "<td> <input type='password' name='pass' value='' /> </td> "
 //       . "</tr>"
 //       . "<tr> "
 //       . "<td> Retype: </td> "
 //       . "<td> <input type='password' name='retypepass' value='' /> </td> "
 //       . "</tr>"
 //       . "</table> "
 //       . "<input type='submit' name='registerbtn' value='Register' /> "
 //       . "<a href=index.php><button type='button'>Go back</button></a> "
 //       . "</form>";
        

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
//                                            echo "An error has occurred. Your account was not created.";
                                            echo "<script type='text/javascript'>alert('An error has occurred. Your account was not created.')</script>";
                                        }
                                        
                                    }
                                    else{
//                                        echo "The user already exists with the same username. $form";
                                        echo "<script type='text/javascript'>alert('That USERNAME already exists.')</script>";
                                        echo $form;
                                    }
                                        
                                }
                                else{
//                                    echo "A user already exists with the same email address. $form";
                                    echo "<script type='text/javascript'>alert('A username already exists with that EMAIL address.')</script>";
                                    echo $form;
                                }
                                    
                                mysql_close();
                            }
                            else{
//                                echo "You must enter a valid <font color='red'>EMAIL</font> address to register. $form";
                                echo "<script type='text/javascript'>alert('You must enter a valid EMAIL address to register.')</script>";
                                echo $form;
                            }
                        }
                        else{
//                            echo "Your <font color='red'>PASSWORD</font> did not match. $form";
                            echo "<script type='text/javascript'>alert('Your retyped PASSWORD did not match')</script>";
                            echo $form;
                        }
                    }
                    else{
//                        echo "You must retype your <font color='red'>PASSWORD</font> to register. $form";
                        echo "<script type='text/javascript'>alert('You must retype your PASSWORD to register')</script>";
                        echo $form;
                    }
                }
                else{
//                    echo "You must enter your <font color='red'>PASSWORD</font> to register. $form";
                    echo "<script type='text/javascript'>alert('You must enter your PASSWORD to register')</script>";
                    echo $form;
                }
            }
            else{
//                echo "You must enter your <font color='red'>EMAIL</font> to register. $form";
                echo "<script type='text/javascript'>alert('You must enter your EMAIL to register')</script>";
                echo $form;
            }
        }
        else{
//            echo "You must enter your <font color='red'>USERNAME</font> to register. $form";
            echo "<script type='text/javascript'>alert('You must enter your USERNAME to register')</script>";
            echo $form;
        }
    }
    else{
        echo $form;
    } 
include "view/footer.php";

?> 
