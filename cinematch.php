<?php
session_start();
?>

<!DOCTYPE html>
<head>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<header>
    <h2>Welcome to Cinematch!</h2>
</header>
<body>
    <div id="login" style="absolute-position: 0px, 100px;">
        <p>Login</p>
        <form method="POST" action="cinematch.php">
        <input type="text" name="username">Username<br>
        <input type="text" name="password">Password<br>
        <input type="submit" name="log_in" value="Log In">
        </form>
        <button onclick="visitSignUp()">Sign up</button>
    
    </div>
<?php
    //If there is input
    if(!empty($_POST)) {

    }
?>
</body>
</html>