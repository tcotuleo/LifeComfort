<?php

session_start();
include "view/header.php";

//This function will destroy your session

session_destroy();

echo "You are now logged out! <a href=index.php>Index</a> or <a href=login.php>Login</a>";

include "view/footer.php";
?>

