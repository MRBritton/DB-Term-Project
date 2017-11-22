<?php
session_start();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cinematch">
    <script src="script.js"></script>
<style>  
    html {
        background-color: #dfdfdf;
    }
    table, tr, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    table tr:nth-child(even) {
        background-color: lightgoldenrodyellow;
    }

    table tr:nth-child(odd) {
       background-color: lightcyan
    }
</style>
</head>

<body>
<p>Names of movies that you like??</p>
<form method="POST" action="my_profile.php" accept-charset="UTF-8">
    <!--TODO: Some Ajax/jQuery trickery for movies like what they're typing?-->
    <input type="text" name="movie_name" required>Movie name<br>
    <input type="submit"  name="add_movie" value="Submit">
</form>
<hr>

<p>Movies you no longer like?</p>
<form method="POST" action="my_profile.php" accept-charset="UTF-8">
    <input type="text" name = "movie_name" required>Movie name<br>
    <input type="submit" name="remove_movie" value="Submit">
</form>
<hr>

<p>Change your favorite actor?</p>
<form method="POST" action="my_profile.php" accept-charset="UTF-8">
    <input type="text" name="actor_name" required>Actor name<br>
    <input type="submit" name="change_fav_actor" value="Submit">
</form>
<hr>


<button onclick="returnHome()">Back</button>

<?php    
    $userID = 0;
    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
    }
    $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

    //handle adding a liked movie
    if(isset($_POST["add_movie"])) {
        $movieName = $_POST["movie_name"];
        
        //TODO: Make stored procedures for this
        $query = "INSERT INTO Likes(userID, movieID)
                SELECT '$userID' as userID, 
                (SELECT id FROM Movies WHERE name = '" . utf8_decode($movieName) ."') as movieID";

        if(mysqli_query($db, $query)) {
            print("Successfully updated your likes!");
        }
        else {
            print("Could not update your likes.<br>Maybe you've already added that movie?<br>Maybe you misspelled the movie's name?");
        }
    }

    //handle removing a movie on the liked list
    elseif(isset($_POST["remove_movie"])) {
        $movieName = $_POST["movie_name"];

        $query = "DELETE FROM Likes
                  WHERE movieID = (SELECT id
                                   FROM Movies
                                   WHERE name = '" .utf8_decode($movieName) ."');";
        if(mysqli_query($db, $query)) {
            print("<p>Successfully removed!</p>");
        }
        else {
            print("<p>Could not remove movie from your likes.</p>");
        }
    }

    //handle updating favorite actor
    elseif(isset($_POST["change_fav_actor"])) {
        $new_fav = $_POST["actor_name"];

        $query = "UPDATE FavoriteActor
                  SET actorID = (SELECT id FROM Actors WHERE name = '" . utf8_decode($new_fav) . "')
                  WHERE userID = $userID;";
        //TODO: error handling
        mysqli_query($db, $query);
    }

    //display favorite actor
    $query = "SELECT name
              FROM Actors
              WHERE id = (SELECT actorID
                          FROM FavoriteActor
                          WHERE userID = $userID);";

    $result = mysqli_query($db, $query);

    $fav_actor_name = "";
    while($row = mysqli_fetch_assoc($result)) {
        $actor_name = $row["name"];
    }

    print("<p style=\"text-align:center\">Favorite actor: $actor_name</p>");

    //Display liked movies
    $query = "SELECT name
              FROM (SELECT movieID
                    FROM Likes
                    WHERE userID = $userID) LikedMovies, Movies
            WHERE LikedMovies.movieID = Movies.id;";
    $result = mysqli_query($db, $query);

    print("<table align=\"center\">");
    print("<caption>Liked movies</caption>");
    while($row = mysqli_fetch_assoc($result)) {
        print("<tr><td>".utf8_encode($row["name"])."</tr></td>");
    }
    print("</table>");

    mysqli_close($db);
?>
</body> 

</html>