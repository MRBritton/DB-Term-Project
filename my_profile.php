<?php
session_start();
?>

<!DOCTYPE html>
<head>
</head>

<body>
<p>Names of movies that you like??</p>
<form method="POST" action="my_profile.php">
    <!--TODO: Some Ajax trickery for movies like what they're typing?-->
    <input type="text" name="movie_name" required>Movie name<br>
    <input type="submit" value="Submit">
</form>
<?php
    /*
    $userID = -1;
    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
    }
    */
    if(isset($_POST["movie_name"])) {
        $movieName = $_POST["movie_name"];
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
        //TODO: Make stored procedures for this
        $query = "INSERT INTO Likes(userID, movieID)
                SELECT '$userID' as userID, 
                (SELECT id FROM Movies WHERE name = '$movieName') as movieID";

        mysqli_query($db, $query);

        mysqli_close($db);
    }
?>
</body>

</html>