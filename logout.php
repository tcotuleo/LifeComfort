<?php
    //To start the session
    session_start();

    //Align all text to center
    //echo "<div style='text-align: center'>";
    
    $page_title = "Logout";
    include "view/newheader.php";

    //To distroy the session
    session_destroy();
    include "view/footer.php";
?>
<html>

<head>

  <meta charset="UTF-8">

  <title>Logout Page</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />

</head>

<body>

    <div class='disclaimer-card'>
    <h1>You are now logged out! </h1><br>

   
        <div class='login-help'>
            <a href='login.php'>Login</a>
                    </div>

    </div>
    <script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>

</body>

</html>