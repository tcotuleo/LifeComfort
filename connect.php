<?php

//Connecting to database

$connect = mysql_connect('127.0.0.1', 'root', '');

if(!$connect){

die(mysql_error());

}


//Selecting database

$select_db = mysql_select_db("test", $connect);

if(!$select_db){

die(mysql_error());

}
?>


