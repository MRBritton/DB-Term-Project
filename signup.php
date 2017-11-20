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
<button onclick="returnHome()">Back</button><br>


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
        
        if(!mysqli_affected_rows($db)) {
            print("Could not create an account with provided credentials");
        }
        //Log the new user in automatically
        else {
            $query = "SELECT id
                    FROM Users
                    WHERE username = '$new_username' AND password = '$new_password';";
            $result = mysqli_query($db, $query);

            $userID = 0;
            while($row = mysqli_fetch_assoc($result))
                $userID = $row["id"];
            $_SESSION["userID"] = $userID;
            

            //Update their favorite actor
            $query = "INSERT INTO FavoriteActor(userID, actorID)
                    SELECT ($userID) as userID, 
                        (SELECT id 
                        FROM Actors 
                        WHERE name = '$new_fav_actor') as actorID";
            mysqli_query($db, $query);
        }
    }

    mysqli_close($db);
    

?>
</body>
</html>