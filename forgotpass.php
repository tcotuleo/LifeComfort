<?php
    //This will start a session
    session_start();

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Password reset page";
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
        $form = "<div class='login-card'>
                    <h1>Forgot Password</h1><br>
                    <form action='forgotpass.php' method='post'>
                        <input type='text' name='username' placeholder='Username'>
                        <input type='text' name='email' placeholder='Email'>
                        <input type='submit' name='submitbtn' class='login login-submit' value='Submit'>
                    </form>

                    <div class='login-help'>
                      <a href='index.php'>Cancel</a>
                    </div>
                </div>";
        
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

//                        echo "<font color='red'>USERNAME</font> is wrong! . $form";
                        echo "<script type='text/javascript'>alert('USERNAME is wrong!')</script>";
                        echo $form;
                        exit();
                    }
                    
                    $pass_check = mysql_query("SELECT * FROM users WHERE username='$getusername' AND id='$id'");
                    $row3 = mysql_fetch_array($pass_check);
                    $email = $row3['email'];
                    $select_pass = mysql_query("SELECT * FROM users WHERE username='$getusername' AND id='$id' AND email='$email'");
                    $row4 = mysql_fetch_array($select_pass);
                    $real_password = $row4['password'];
                    
                    //Check if the entered password matches the associated username in our database.
                    if($getemail != $email){
                        echo "<script type='text/javascript'>alert('You must enter the correct EMAIL address associated with your username.')</script>";
                        echo $form;
                        exit();
                    }
                    else{
                        //Now if everything is correct let's finish his/her change password request 
                        //$_SESSION["username"] = $getusername;
                        //$_SESSION["email"] = $getemail;
                        include "smtpmail/classes/class.phpmailer.php"; // include the class name
                            //if(isset($_POST["send"])){
                            $email = $_POST["email"];
                            $mail = new PHPMailer(); // create a new object
                            $mail->IsSMTP(); // enable SMTP
                            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                            $mail->SMTPAuth = true; // authentication enabled
                            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                            $mail->Host = "smtp.gmail.com";
                            $mail->Port = 465; // or 587
                            $mail->IsHTML(true);
                            $mail->Username = "lifecomfortrc@gmail.com";
                            $mail->Password = "Lifecomfort123";
                            $mail->SetFrom("lifecomfortrc@gmail.com");
                            $mail->Subject = "Lifecomfort Password reset request";
                            $mail->Body = "<b>Hi,". $getusername. " your password is ". $real_password. "<br/><br/><a href='http://localhost:8000/login.php'>LifeComfort.com</a></b>";
                            $mail->AddAddress($getemail);
                            
                            if(!$mail->Send()){
                                echo "<script type='text/javascript'>alert('Mailer Error: ')</script>" . $mail->ErrorInfo;
                            }
                            else{
                                echo "<script type='text/javascript'>alert('Your recommendation email to ". $email . " has been sent.)</script>";
                            }
                    }             
                }
                else{
                    echo "<script type='text/javascript'>alert('You must enter your EMAIL.')</script>";
                    echo $form;
                }      
            }
            else{
                echo "<script type='text/javascript'>alert('You must enter your USERNAME.')</script>";
                echo $form;
            }
        }
        else {
            echo $form;
        }
    }

    include "view/footer.php";
?>