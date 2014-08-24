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
        <title>Login System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div></div>
        <?php
        
        if ($username && $userid){
            echo "Welcome <b>$username</b>, <a href='logout.php'>Logout</a>";
            echo "<br /> <a href='resetpass.php'>Reset your password</a>";
        }
        else{
            echo "Please login to access this page. <a href='login.php'>Login </a>";
        }
        ?>
        
    </body>
</html>


