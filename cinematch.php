<?php
session_start();
?>

<!DOCTYPE html>
<head>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<header>
    <h2>Welcome to Cinematch
        <?php
            if(isset($_SESSION["userID"])){
                $db = mysqli_connect("db1.cs.uakron.edu", "mrb182", "cai5viCu", "ISP_mrb182");
                $result = mysqli_query($db, "SELECT username FROM Users WHERE id = " . $_SESSION["userID"]);
                $un = "";
                while($row = mysqli_fetch_assoc($result)) {
                    $un = $row["username"];
                }
                print($un);
                mysqli_close($db);
            }
        ?>
        !</h2>
</header>
<body>
    <div id="login">
        <p>Login</p>
        <form method="POST" action="login.php">
        <input type="text" name="username" required>Username<br>
        <input type="text" name="password" required>Password<br>
        <input type="submit" name="log_in" value="Log In">
        </form>
        <button onclick="visitSignUp()">Sign up</button><br>
        <a href="search.php">Search movies</a>
    
    </div>

    <?php
        if(isset($_SESSION["userID"])) {
            print "<a href=\"my_profile.php\">Edit profile</a>";
        }
    ?>

</body>
</html>