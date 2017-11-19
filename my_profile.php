<?php
session_start();
?>

<!DOCTYPE html>
<head>
<script src="script.js"></script>
<style>
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
<form method="POST" action="my_profile.php">
    <!--TODO: Some Ajax/jQuery trickery for movies like what they're typing?-->
    <input type="text" name="movie_name" required>Movie name<br>
    <input type="submit"  name="add_movie" value="Submit">
</form>
<hr>

<p>Movies you no longer like?</p>
<form method="POST" action="my_profile.php">
    <input type="text" name = "movie_name" required>Movie name<br>
    <input type="submit" name="remove_movie" value="Submit">
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
                (SELECT id FROM Movies WHERE name = '$movieName') as movieID";

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
                                   WHERE name = '$movieName');";
        mysqli_query($db, $query);
    }

    //Display liked movies
    $query = "SELECT name
              FROM (SELECT movieID
                    FROM Likes
                    WHERE userID = $userID) LikedMovies, Movies
            WHERE LikedMovies.movieID = Movies.id;";
    $result = mysqli_query($db, $query);

    print("<table align=\"center\">");
    print("<caption>Likes</caption>");
    while($row = mysqli_fetch_assoc($result)) {
        print("<tr><td>".$row["name"]."</tr></td>");
    }
    print("</table>");
?>
</body> 

</html>