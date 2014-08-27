<?php
    //This will start a session
    session_start();

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Login Page";
    include "view/header.php";

    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    }
    
    //Check for the database connection
    require("connect.php");
    
    //Display the logged in if a user already logged in.
    if(isset($username) && isset($password)){
        
        echo "You are already logged in as <b>$dbusername</b>. please continue on our <a href=website.php><button type='button'>Main Page</button></a>";
    }
    else{
        
        //Create a varible to display the login form.
        $form = "<form action='login.php' method='post'> "
            . "<table align='center' width='25%' bordercolor='#D2691E' bgcolor='#A3C1AD'> "
            . "<tr> "
            . "<td> Username: </td> "
            . "<td> <input type='text' name='username' size='30'> </td> "
            . "</tr>"
            . "<tr> "
            . "<td> Password: </td> "
            . "<td> <input type='password' name='password' size='30'> </td> "
            . "</tr>"
            . "</table> "
            . "<input type='submit' name='loginbutton' value='Login'>"
            . "<a href=forgotpass.php><button type='button'>Forgot password?</button></a>"
            . "<a href=index.php><button type='button'>Home</button></a>"
            . "</form>";
        
        //This if statement will run if the login button is pressed.
        if (isset($_POST['loginbutton'])){

            //Get the entered username from the form.
            $username = $_REQUEST['username'];

            //Get the entered password from the form.
            $password = $_REQUEST['password'];

            //Check if the entered username is not empty.
            if ($username != NULL){

                //Check if the entered password is not empty.
                if ($password != NULL){

                    //Check if entered data matches our database record.
                    $result = mysql_query("SELECT * FROM users WHERE username='$username'");
                    $row = mysql_fetch_array($result);
                    $id = $row['id'];

                    $select_user = mysql_query("SELECT * FROM users WHERE id='$id'");
                    $row2 = mysql_fetch_array($select_user);
                    $user = $row2['username'];

                    //Check if the entered username matches the username in our database system.
                    if($username != $user){

                        echo "Your <font color='red'>USERNAME</font> is wrong! . $form";
                        exit();
                    }
                    
                    $pass_check = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id'");
                    $row3 = mysql_fetch_array($pass_check);
                    $email = $row3['email'];
                    $select_pass = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id' AND email='$email'");
                    $row4 = mysql_fetch_array($select_pass);
                    $real_password = $row4['password'];
                    
                    //Check if the entered password matches the associated username in our database.
                    if($password != $real_password){

                        echo "You must enter the correct <font color='red'>PASSWORD</font>!. $form";
                        exit();
                    }

                    //Now if everything is correct let's finish his/her/its login
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                    include 'website.php';
                }
                else{
                    echo "You must enter your <font color='red'>PASSWORD</font>. $form";
                }
            }
            else{
                echo "You must enter your <font color='red'>USERNAME</font>. $form";
            }
        }
        else {
            echo $form;
        }
    }
    
    include "view/footer.php";
?>