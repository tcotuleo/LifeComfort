<?php

session_start();


//This displays your login form

function index(){


echo "<form action='?act=login' method='post'>"

."Username: <input type='text' name='username' size='30'><br>"

."Password: <input type='password' name='password' size='30'><br>"

."<input type='submit' value='Login'>"

."</form>";


}


//This function will find and checks if your data is correct

function login(){


//Collect your info from login form

$username = $_REQUEST['username'];

$password = $_REQUEST['password'];



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


//Find if entered data is correct


$result = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");

$row = mysql_fetch_array($result);

$id = $row['id'];


$select_user = mysql_query("SELECT * FROM users WHERE id='$id'");

$row2 = mysql_fetch_array($select_user);

$user = $row2['username'];


if($username != $user){

die("Username is wrong!");

}



$pass_check = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id'");

$row3 = mysql_fetch_array($pass_check);

$email = $row3['email'];

$select_pass = mysql_query("SELECT * FROM users WHERE username='$username' AND id='$id' AND email='$email'");

$row4 = mysql_fetch_array($select_pass);

$real_password = $row4['password'];


if($password != $real_password){

die("Your password is wrong!");

}




//Now if everything is correct let's finish his/her/its login


session_register("username", $username);

session_register("password", $password);


echo "Welcome, ".$username." please continue on our <a href=index.php>Index</a>";





}


switch($act){


default;

index();

break;


case "login";

login();

break;


}

?> 