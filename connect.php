<?php
$connection = mysql_connect('127.0.0.1', 'root', '');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('lifecomfortusers');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}