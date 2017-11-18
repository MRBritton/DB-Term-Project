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
    <input type="text" name="fav_actor" value="Harrison Ford" required>Who is your favorite actor?<br>
    <input type="submit" name="sign_up" value="Sign up">
</form>
<button onclick="returnHome()">Back</button>

<?php
    $db_server = "db1.cs.uakron.edu:3306";
    $username = "mrb182";
    $password = "cai5viCu";

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
        $query = "INSERT INTO UsersCM
                (username, password)
                VALUES ('$username', '$password');";
        
        mysqli_query($db, $query);
        
        /*
        //If the user is successfully inserted
        if(mysqli_query($db, $query)) {
            //Update favorite actor
            $query = "INSERT INTO FavoriteActor(userID, actorID)
                    SELECT (SELECT id FROM UsersCM WHERE username = '$username') as userID,
                           (SELECT id FROM Actors WHERE name = '$new_fav_actor') as actorID;";
            //If the user's favorite actor is successfully updated, creation is complete
            if(mysqli_query($db, $query)) {
                //Get the userID to serve as a $_SESSION variable
                $userID = -1;
                $result = mysqli_query($db, "SELECT id FROM UsersCM WHERE username = '$username';");
                while($row = mysqli_fetch_assoc($result)) {
                    //There's only one row
                    $userID = $row["id"];
                }
                $_SESSION["userID"] = $userID;
            }
        }
        */
    }
    

?>
</body>
</html>