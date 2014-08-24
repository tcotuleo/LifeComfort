<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<html>
    <head>
        <title>Login System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div></div>
        <?php
        
        if($username && $userid){
            echo "You are already logged in as <b>$dbusername</b>. <a href='member.php'>Click here</a> to go the main page.";
        }
        else{
        $form = "<form action='login.php' method='post'> "
                . "<table> "
                . "<tr> "
                . "<td> Username: </td> "
                . "<td> <input type='text' name='user' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td> Password: </td> "
                . "<td> <input type='password' name='password' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td></td> "
                . "<td> <input type='submit' name='loginbtn' value='Login' /> </td> "
                . "</tr> "
                . "<tr> "
                . "<td><a href='register.php'>Register</a> </td> "
                . "<td><a href='forgotpass.php'>Forgot Password?</a></td> "
                . "</tr> "
                . "</table> "
                . "</form>";
        
        if ($_POST['loginbtn']){
            $user = $_POST['user'];
            $password = $_POST['password'];
            
            if ($user){
                if ($password){
                    require("connect.php");
                    
                    $password = md5(md5("kjfiufj".$password."Fj56fj"));
                    
                    //Making sure login info is correct
                    $query = mysql_query("SELECT * FROM users WHERE username='$user'");
                    $numrows = mysql_num_rows($query);
                    if ($numrows == 1){
                        $row = mysql_fetch_assoc($query);
                        $dbid = $row['id'];
                        $dbuser = $row['username'];
                        $dbpass = $row['password'];
                        $dbactive = $row['active'];
                        
                        if ($password == $dbpass){
                            if ($dbactive == 1){
                                //setting the session information
                                $_SESSION['userid'] = $dbid;
                                $_SESSION['username'] = $dbuser;
                                
                                echo "You have been logged in as <b>$dbuser</b>. <a href='member.php'>Click here</a> to go the main page.";
                            }
                            else {
                                echo "You must a activate your account to login. $form";
                        }
                            
                        }
                        else {
                            echo "You must enter correct password";
                        }
                        
                    }
                    else {
                        echo "The entered username was not found. $form";
                    }
                    
                    mysql_close();
                    
                }
                else {
                    echo "you must enter your password. $form";
                }
            }
            else{
                echo "You must enter your username. $form";
            }
        }
        else {
            echo $form;
        }
        }
        ?>
    </body>
</html>

