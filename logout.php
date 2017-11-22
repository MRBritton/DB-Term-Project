<?php
    session_start();
?>
<!DOCTYPE html>
<head>
    <script src="script.js"></script>
    <style>
        html {
            background-color: #dfdfdf;
        }
    </style>
</head>

<body>
    <?php
    session_unset();
    session_destroy();

    if(!isset($_SESSION["userID"])) {
        print("<p>Successfully logged out!</p>");
        print("<button onclick=\"returnHome()\">Home</button>");
    }
    else {
        print("<p>Unable to log out successfully.</p>");
    }
?>
</html>