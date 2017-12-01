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
            opacity : 0;
        }
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
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
    //please don't look to hard at this, it's not good for your health
    function similarMovies($db, $userID) {
        $query = "SELECT *
    FROM Movies  
    WHERE 
    (
    
        /* The movie's release year is +-5 of the average release year of movies liked by the user */
    
        (Movies.releaseYear <=
        
            (SELECT AVG(releaseYear) as avgLikedYear
    
            FROM 	(SELECT movieID as likedMovieId
            
                FROM Likes, Movies
            
                WHERE Movies.id = Likes.movieID AND userID = $userID) UserLikes, Movies
        
            WHERE Movies.id = UserLikes.likedMovieId) + 5
         
        AND
         
        Movies.releaseYear >= 
             
            (SELECT AVG(releaseYear)
         
            FROM 	(SELECT movieID as likedMovieId
            
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
    
    
    OR
    
    /* The movie stars the user's favorite actor */
    Movies.id IN 
        (SELECT id
        
    FROM Movies,
    
            (SELECT movieID
            
    FROM StarsIn
            
    WHERE actorID = 
        
                (SELECT actorID
        
                FROM FavoriteActor
        
                WHERE userID = $userID)) FaveStarsIn
    
        WHERE Movies.id = FaveStarsIn.movieID);";

        $result = mysqli_query($db, $query);

        return $result;
    }

    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

        $similarMovies = similarMovies($db, $userID);
        if(mysqli_num_rows($similarMovies) == 0) {
            print "<p>We couldn't find any movies that you might like, so here are some randomly selected movies for you to check out!</p>";
            $query = "SELECT name, rating, releaseYear FROM Movies
            ORDER BY RAND()
            LIMIT 5";
            $similarMovies = mysqli_query($db, $query);
        }

        print "<table>
               <tr><th>Name</th><th>Rating</th><th>Release Year</th><th>More info</th></tr>";
        while($row = mysqli_fetch_assoc($similarMovies)) {
            print "<tr><td>" . utf8_encode($row["name"]) . "</td><td>" . $row["rating"] . "</td><td>" . $row["releaseYear"] . "</td>";
            print "<td><form action=\"info.php\" method=\"POST\">
                   <input type=\"text\" name=\"movie\" class=\"invisible\" value=\"" . $row["name"] . "\" readonly>
                   <input type=\"submit\"  value=\"?\"></form></td></tr>";
            print "</tr>";
        }
        print "</table>";

        mysqli_close($db);
    }
?>
<button onclick="returnHome()">Back</button><br>
</body>
</html>