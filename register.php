<form action='register' method='post'> 
Name: <input type='text' name='name' size='30'><br>
Username: <input type='text' name='username' size='30'><br>
Password: <input type='password' name='password' size='30'><br>
Confirm your password: <input type='password' name='password_conf' size='30'><br> 
Email: <input type='text' name='email' size='30'><br> 
<input type='submit' name="register" value='Register'>
</form>
<?php
require('connect.php');

//This function will display the registration form
//This function will register users data
function register(){

//Connecting to database
$connect = mysql_connect('127.0.0.1', 'root', '');
if(!$connect){
die(mysql_error());
}

//Selecting database
$select_db = mysql_select_db("lifecomfortusers", $connect);
if(!$select_db){
die(mysql_error());
}

//Collecting info
$name = $_REQUEST['name'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$pass_conf = $_REQUEST['password_conf'];
$email = $_REQUEST['email'];
$date = $_REQUEST['date'];

//Here we will check do we have all inputs filled
if(empty($name)){
die("Please enter your username!<br>");
}

if(empty($username)){

die("Please enter your username!<br>");

}


if(empty($password)){

die("Please enter your password!<br>");

}


if(empty($pass_conf)){

die("Please confirm your password!<br>");

}


if(empty($email)){

die("Please enter your email!");

}


//Let's check if this username is already in use


$user_check = mysql_query("SELECT username FROM users WHERE username='$username'");

$do_user_check = mysql_num_rows($user_check);


//Now if email is already in use


$email_check = mysql_query("SELECT email FROM users WHERE email='$email'");

$do_email_check = mysql_num_rows($email_check);


//Now display errors


if($do_user_check > 0){

die("Username is already in use!<br>");

}


if($do_email_check > 0){

die("Email is already in use!");

}


//Now let's check does passwords match


if($password != $pass_conf){

die("Passwords don't match!");

}



//If everything is okay let's register this user


$insert = mysql_query("INSERT INTO users (name, username, password, email) VALUES ('$name', '$username', '$password', '$email')");

if(!$insert){

die("There's little problem: ".mysql_error());

}


echo $name.", you are now registered. Thank you!<br><a href=login.php>Login</a> | <a href=index.php>Index</a>";
echo $username.", is your username.";

}


if (!isset($_POST))
        register_form();
    else {
    register();


}


?> 