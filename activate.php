<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        
        $getuser = $_GET['user'];
        $getcode = $_GET['code'];
        
        
        
        if ($_POST['activatebtn']){
            $getuser = $_POST['user'];
            $getcode = $_POST['code'];
            
            if ($getuser){
                
                if ($getcode){
                    
                    require ("connect.php");
                    
                    $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                    $numrows = mysql_num_rows($query);
                    if ($numrows == 1){
                        $row = mysql_fetch_assoc($query);
                        $dbcode = $row['code'];
                        $dbactive = $row['active'];
                        
                        if($dbactive == 0){
                            if($dbcode == $getcode){
                                mysql_query("UPDATE users SET active='1' WHERE username='$getuser'");
                                $query = mysql_query("SELECT * FROM users WHERE username='$getuser' AND active='1' ");
                                $numrows = mysql_num_rows($query);
                                if($numrows == 1){
                                    $errormsg = "Your account has been activated. You may not login.";
                                    $getuser = "";
                                    $getcode = "";
                                    
                                }
                                else{
                                    $errormsg = "An error has occured. Your account was not activated";
                                }
                            }
                            else{
                                $errormsg = "Your code is incorrect.";
                            }
                        }
                        else{
                            $errormsg = "This account is already active.";
                        }
                    }
                    else{
                        $errormsg = "The username you entered was not found.";
                    }
                    
                    mysql_close();
                }
                else{
                    $errormsg = "You must enter your code.";
                }
            }
            else{
                $errormsg = "You must enter your username.";
            }
        }
        else{ 
            $errormsg = "";
        }
            
            
        echo "<form action='activate.php' method='post'> "
                . "<table>"
                . "<tr> "
                . "<td></td> "
                . "<td>$errormsg</td> "
                . "</tr>"
                . "<tr> "
                . "<td>Username:</td> "
                . "<td> <input type='text' name='user' value='$getuser' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td>Code:</td> "
                . "<td> <input type='text' name='code' value='$getcode' /> </td> "
                . "</tr>"
                . "<tr> "
                . "<td></td> "
                . "<td> <input type='submit' name='activatebtn' value='Activate' /> </td> "
                . "</tr>"
                . "</table></form";;
        
        ?>
    </body>
</html>
