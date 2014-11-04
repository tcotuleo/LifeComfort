<?php

    //This will start a session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //Align all text to center
    echo "<div style='text-align: center'>";
    
    $page_title = "Login/Register";
    include_once "view/header.php";
    
    //Check if a user is already logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
    } else {
        echo "<script type='text/javascript'>alert('Both session variables are not set.')</script>";
    }

    //If no user is logged in then display the main login page.
    if(!isset($username) && !isset($password)){
        echo "Welcome Guest! <br> <a href=login.php><button type='button'>Login</button></a> | <a href=register.php><button type='button'>Register</button></a>";
        exit();
    }
    else{
        include "smtpmail/classes/class.phpmailer.php"; // include the class name
            if(isset($_POST["send"])){
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
            $mail->Subject = "A recommendation to use LifeComfort calculator";
            $mail->Body = "<b>Hi,". $username. " has invited you to try LifeComfort retirement calculator. Click the link below to go to the website.<br/><br/><a href='http://localhost:8000/login.php'>LifeComfort.com</a></b>";
            $mail->AddAddress($email);
             if(!$mail->Send()){
                    echo "<script type='text/javascript'>alert('Mailer Error: ')</script>" . $mail->ErrorInfo;
            }
            else{
                    echo "<script type='text/javascript'>alert('Your recommendation email to ". $email . " has been sent.)</script>";
            }
       
        
    }

}
?>
<div class='login-card'>
                    <h1>Refer Friend</h1>
                    <form action='' method='post'>
                        <table class="mytable">
                        <input type='text' name='email' placeholder='Email'>
                        <input type='submit' name='send' class='login login-submit' value='Submit'>
                        </table>
                    </form>

                    <div class='login-help'>
                        <a href='website.php'>Cancel</a>
                    </div>
                </div>
