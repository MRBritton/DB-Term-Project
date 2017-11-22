<?php
session_start();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cinematch">
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        html {
            background-color: #dfdfdf;
        }
        nav {
            background-color: white;
            padding: 5px;
            margin: auto;
            width: 20%;
            text-align: center;
            border: 1px solid black;
            border-radius: 3px;
        }
        #welcome {
            text-align: center;
        }
        #login {
            text-align: center;
            position: absolute;
            top: 5px;
            right: 100px;
            padding: 5px;
            min-height: 100px;
            min-width: 100px;
            border: 3px solid black;
            border-radius: 10px;
        }
    </style>
</head>

<header>
    <h2 id="welcome">Welcome to Cinematch
        <?php
            if(isset($_SESSION["userID"])){
                $db = mysqli_connect("db1.cs.uakron.edu", "mrb182", "cai5viCu", "ISP_mrb182");
                $result = mysqli_query($db, "SELECT username FROM Users WHERE id = " . $_SESSION["userID"]);
                $un = "";
                while($row = mysqli_fetch_assoc($result)) {
                    $un = $row["username"];
                }
                print(", " . $un);
                mysqli_close($db);
            }
        ?>
        !</h2>
</header>
<body>
    <?php
    if(!isset($_SESSION["userID"])) {
        print "
        <div id=\"login\">
        <p>Login</p>
        <form method=\"POST\" action=\"login.php\">
        <input type=\"text\" name=\"username\" required>Username<br>
        <input type=\"text\" name=\"password\" required>Password<br>
        <input type=\"submit\" name=\"log_in\" value=\"Log In\">
        </form>
        <button onclick=\"visitSignUp()\">Sign up</button><br>
        </div>";
    }
    else {
        print "
        <div id=\"login\">
        <p>Log out</p>
        <form method=\"POST\" action=\"logout.php\">
        <input type=\"submit\" value=\"Log Out\">
        </form>
        </div>
        ";
    }
    ?>
    <nav>
    <a href="search.php">Search movies</a>
    <?php
        if(isset($_SESSION["userID"])) {
            print " | <a href=\"my_profile.php\">Edit profile</a>";
        }
    ?>
    </nav>

</body>
</html>