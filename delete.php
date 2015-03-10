<?php
include "admindeleteuser.php";
require 'connect.php';

$deleteid = $_GET['id'];

$query = mysql_query("DELETE FROM users where id = '$deleteid'");
if($query)
{
    echo "<div class=login-card ><h2><font color='red'>Record Successfully Deleted</font></h2></div>";
}
?>