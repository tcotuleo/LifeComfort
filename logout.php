<?php
session_start();
?>
<div style='text-align: center'>
    <?php
include "view/header.php";

//This function will destroy your session

session_destroy();

echo "You are now logged out! <a href=index.php><button type='button'>Home</button></a> or <a href=login.php><button type='button'>Login</button></a>";

include "view/footer.php";
?>
</div>