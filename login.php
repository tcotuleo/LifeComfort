<?php

session_start();
include "view/header.php";

if (isset($username) && isset($password)) {
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
}
require 'connect.php';

//This displays your login form

//function index(){
if(isset($username) && isset($password)){
            echo "You are already logged in as <b>$dbusername</b>. please continue on our <a href=index.php>Index</a>";
}
else{
    $form = "<form action='?act=login' method='post'> "
                ."<div style='text-align: center' "
                . "<table border='1' > "
                . "<tr> "
                . "<td> Username: </td> "
                . "<td> <input type='text' name='username' size='30' /> </td> "
                . "</tr> <br />"
                . "<tr> "
                . "<td> Password: </td> "
                . "<td> <input type='password' name='password' size='30' /> </td> "
                . "</tr> <br />"
                . "</table> "
                . "<input type='submit' name='loginbutton' value='Login' />"
                ."<a href=index.php><button type='button'>Home</button></a>"
                ."</div>"
                . "</form>";


    //$form = "<form action='?act=login' method='post'>"

    //."Username: <input type='text' name='username' size='30'><br>"

    //."Password: <input type='password' name='password' size='30'><br>"

    //."<input type='submit' name='loginbutton' value='Login'>"

    //."</form>";


//}


//This function will find and checks if your data is correct

    if (isset($_POST['loginbutton'])){


    //Collect your info from login form

    $username = $_REQUEST['username'];

    $password = $_REQUEST['password'];


    if ($username != NULL){
        if ($password != NULL){
        //Find if entered data is correct

                
$result = mysql_query("SELECT * FROM users WHERE username='$username'");

$row = mysql_fetch_array($result);

$id = $row['id'];


$select_user = mysql_query("SELECT * FROM users WHERE id='$id'");

$row2 = mysql_fetch_array($select_user);

$user = $row2['username'];


if($username != $user){

echo "Username is wrong! . $form";
exit();



}



$pass_check = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id'");

$row3 = mysql_fetch_array($pass_check);

$email = $row3['email'];

$select_pass = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id' AND email='$email'");

$row4 = mysql_fetch_array($select_pass);

$real_password = $row4['password'];


if($password != $real_password){

echo "You must enter correct password!. $form";
exit();

}




//Now if everything is correct let's finish his/her/its login


$_SESSION["username"] = $username;
$_SESSION["password"] = $password;
//session_register("username", $username);

//session_register("password", $password);


                include 'website.php';
        }
        else{
         echo "You must enter your password. $form";
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
include "view/footer.php";

?> 