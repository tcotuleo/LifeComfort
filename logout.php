<?php
    //To start the session
    session_start();

    //Align all text to center
    echo "<div style='text-align: center'>";
    
    include "view/header.php";

    //To distroy the session
    session_destroy();
    echo "<table align='center' width='25%' bordercolor='#D2691E' bgcolor='#A3C1AD'>";
    echo "<tr>";
    echo "<td>You are now logged out! <a href=index.php><button type='button'>Home</button></a> or <a href=login.php><button type='button'>Login</button></a></td>";
    echo "</tr></table>";
    
    include "view/footer.php";
?>