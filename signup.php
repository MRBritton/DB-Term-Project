<?php
session_start()
?>
<!DOCTYPE html>
<head>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<form method="POST" action="signup.php">
    <input type="text" name="username" required>Username<br>
    <input type="text" name="password" required>Password<br>
    <input type="text" name="fav_actor" required>Who is your favorite actor?<br>
    <input type="submit" name="sign_up" value="Sign up">
</form>
<button onclick="returnHome()">Back</button>

<?php
    $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

    if(!$db) {
       print("Connection failed: " . mysqli_connect_error());
       exit;
    }
    
    //If there is input to handle
    if(!empty($_POST)) {
        $new_username = $_POST["username"];
        $new_password = $_POST["password"];
        $new_fav_actor = $_POST["fav_actor"];
    

        //TODO: create and call a stored procedure to handle this
        
        //Create the new user
        $query = "INSERT INTO Users
                (username, password)
                VALUES ('$new_username', '$new_password');";
        
        mysqli_query($db, $query);
    }
    

?>
</body>
</html>