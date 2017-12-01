<?php
    session_start();
?>

<!DOCTYPE html>
<head>
    <style>
        html {
            background-color: #dfdfdf;
        }
        .invisible {
            opacity: 0;
        }
        
    </style>

    <script>
        function returnHome() {
            window.location = "cinematch.php";
        }
    </script>
</head>

<body>

<?php
    function similarUsers($db, $userID) {
        $query = "SELECT username
        FROM Users,
        
        (SELECT userID
        FROM Likes,
        
        (SELECT *
        FROM Movies
        WHERE 
        (
        /* The movie's release year is +-5 of the average release year of movies liked by the user */
        (Movies.releaseYear <=
            (SELECT AVG(releaseYear) as avgLikedYear
             FROM (SELECT movieID as likedMovieId
                FROM Likes, Movies
                WHERE Movies.id = Likes.movieID AND userID = $userID) UserLikes, Movies
             WHERE Movies.id = UserLikes.likedMovieId) + 5
             AND
             Movies.releaseYear >= 
                 (SELECT AVG(releaseYear)
             FROM (SELECT movieID as likedMovieId
                FROM Likes, Movies
                WHERE Movies.id = Likes.movieID AND userID = $userID) UserLikes, Movies
             WHERE Movies.id = UserLikes.likedMovieId) - 5)
             
             AND
        
        /* The movie's rating is +-2 of the average rating of movies liked by the user */
             (Movies.rating <= 
        /*
        This gets the average rating of a user's liked movies
        */
        (SELECT AVG(Movies.rating)
        FROM Movies, 
                (SELECT *
                FROM Likes, Movies
                WHERE Movies.id = Likes.movieID AND userID = $userID) likedMovies
        WHERE likedMovies.id = Movies.id) + 2
        AND
        Movies.rating >=
        /*
        This gets the average rating of a user's liked movies
        */
        (SELECT AVG(Movies.rating)
        FROM Movies, 
                (SELECT *
                FROM Likes, Movies
                WHERE Movies.id = Likes.movieID AND userID = $userID) likedMovies
        WHERE likedMovies.id = Movies.id) - 2)
        
        )
        AND
        Movies.id IN (SELECT id
        FROM Movies,
        (SELECT movieID
        FROM StarsIn
        WHERE actorID = 
            (SELECT actorID
            FROM FavoriteActor
            WHERE userID = 8)) FaveStarsIn
        WHERE Movies.id = FaveStarsIn.movieID) ) SimilarMovies
        
        WHERE Likes.movieID = SimilarMovies.id and userID != $userID) SimilarUsers
        
        WHERE Users.id = SimilarUsers.userID";

        $result = mysqli_query($db, $query);

        return $result;
    }

    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
        $db = mysqli_connect("db1.cs.uakron.edu", "mrb182", "cai5viCu", "ISP_mrb182");

        $similarUsers = similarUsers($db, $userID);
        if(mysqli_num_rows($similarUsers) == 0) {
            print "<p>We couldn't find any similar users to recommend for you!</p>";
        }
        else {
            print "<table align=\"center\">
                    <tr><th>Username</th></tr>";
            while($row = mysqli_fetch_assoc($similarUsers)) {
                print "<tr><td>" . $row["username"] . "</td>";
                print "<td><form action=\"user_info.php\" method=\"POST\">
                <input type=\"text\" name=\"suggested_username\" class=\"invisible\" value=\"" . $row["username"] . "\" readonly>
                <input type=\"submit\" value=\"Visit profile\"></form></td></tr>";
            }
            print "</table>";
        }

        mysqli_close($db);
    }
?>
<button onclick="returnHome()">Back</button><br>

</body>
</html>