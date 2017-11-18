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
    <div id="login">
        <p>Login</p>
        <form method="POST" action="login.php">
        <input type="text" name="username" required>Username<br>
        <input type="text" name="password" required>Password<br>
        <input type="submit" name="log_in" value="Log In">
        </form>
        <button onclick="visitSignUp()">Sign up</button>
    
    </div>

    <?php
        if(isset($_SESSION["userID"])) {
            print "<a href=\"my_profile.php\">Edit profile</a>";
        }
    ?>

</body>
</html>