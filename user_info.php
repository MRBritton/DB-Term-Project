<!DOCTYPE html>
<head>
    <style>
        html {
            background-color: #dfdfdf;
        }
    </style>

    <script>
        function returnHome() {
            window.location = "recommend_users.php";
        }
    </script>
</head>

<body>
    <?php
        if(!empty($_POST)) {
            $username = $_POST["suggested_username"];
            $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

            //Find the user's favorite actor
            $favoriteActor = "";
            $query = "SELECT name
            FROM Actors
            WHERE id =
                (
                SELECT actorID
                FROM FavoriteActor
                WHERE userID =
                    (SELECT id
                    FROM Users
                    WHERE username = '$username')
                )";
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) == 1)
                $favoriteActor = mysqli_fetch_assoc($result)["name"];
            
            //Find the movies the user likes
            $query = "select name, rating, releaseYear
                      from Movies
                      where id in
            
                        (SELECT movieID
                        FROM Likes
                        WHERE userID =
            
                            (SELECT id
                            FROM Users
                            WHERE username = '$username'))";
            
            $result = mysqli_query($db, $query);

            //Display the info
            print "<p style=\"text-align: center\"> $username's favorite actor is: $favoriteActor</p>";
            print "<table align=\"center\"";
            while($row = mysqli_fetch_assoc($result)) {
                print "<tr><td>" . $row["name"] . "</td><td>" . $row["rating"] . "</td><td>" . $row["releaseYear"] . "</td></tr>";
            }
            print "</table>";

            mysqli_close($db);
        }
    ?>

<button onclick="returnHome()">Back</button>
</body>
</html>