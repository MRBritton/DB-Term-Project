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
        <input type="text" name="username" required>Username<br>
        <input type="text" name="password" required>Password<br>
        <input type="submit" name="log_in" value="Log In">
        </form>
        <button onclick="visitSignUp()">Sign up</button>
    
    </div>
    <a href="my_profile.php">Edit profile</a> <!--Only display if logged in?-->
<?php
    function validateLogin($username, $password) {
        //query the database to find a matching username
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
        $query = "SELECT id FROM Users WHERE username = '$username' AND password = '$password';";
        $result = mysqli_query($db, $query);

        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row["id"];
        }
        if(!id) {
            //not logged in
        }
        else {
            $_SESSION["userID"] = $id;
        }

        mysqli_close($db);
    }

    $userID = -1;
    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
    }    
    //Do we have input to handle?
    if(!empty($_POST)) {
        //If someone is logging in
        if(isset($_POST["log_in"])) {
            $un = $_POST["username"];
            $pw = $_POST["password"];
            if(validateLogin($un, $pw))
        }
    }
?>
</body>
</html>