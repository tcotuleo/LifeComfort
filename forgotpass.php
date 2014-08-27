<?php
    //This will start a session
    session_start();

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    include_once "view/header.php";

    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }
    
    //Check for the database connection
    require("connect.php");
    
    //Display the logged in if a user already logged in.
    if(isset($username) && isset($password)){
        
        echo "You are already logged in as <b>$dbusername</b>. please continue on our <a href=index.php>Index</a>";
    }
    else{
        
        //Create a varible to display the change password request form.
        $form = "<form action='forgotpass.php' method='post'> "
            . "<table align='center' width='25%' bordercolor='#D2691E' bgcolor='#A3C1AD'> "
            . "<tr> "
            . "<td> Username: </td> "
            . "<td> <input type='text' name='username' size='30'> </td> "
            . "</tr>"
            . "<tr> "
            . "<td> Email: </td> "
            . "<td> <input type='text' name='email' size='30'/> </td> "
            . "</tr>"
            . "</table> "
            . "<input type='submit' name='submitbtn' value='Submit'>"
            . "<a href=index.php><button type='button'>Cancel</button></a>"
            . "</form>";
        
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

                        echo "<font color='red'>USERNAME</font> is wrong! . $form";
                        exit();
                    }
                    
                    $pass_check = mysql_query("SELECT * FROM users WHERE username='$getusername' AND id='$id'");
                    $row3 = mysql_fetch_array($pass_check);
                    $email = $row3['email'];
                    
                    //Check if the entered password matches the associated username in our database.
                    if($getemail != $email){

                        echo "You must enter the correct <font color='red'>EMAIL</font> address associated with your username. $form";
                        exit();
                    }else{

                        //Now if everything is correct let's finish his/her change password request 
                        $_SESSION["username"] = $getusername;
                        $_SESSION["email"] = $getemail;
                        include 'updatepass.php';  
                    }             
                }
                else{
                    echo "You must enter your <font color='red'>Email</font>. $form";
                }      
            }
            else{
                echo "You must enter your <font color='red'>USERNAME</font>. $form";
            }
        }
        //This else statement will run if user didn't enter any data in the change password request form.
        else {
            echo $form;
        }
    }

    include "view/footer.php";
?>