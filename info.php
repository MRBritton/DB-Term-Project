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
        function visitSearch() {
            window.location = "search.php";
        }
    </script>
</head>

<body>
<?php
    if(isset($_POST)) {
        $movie_name = $_POST["movie"];

        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

        $query = "SELECT name
                  FROM Actors, (SELECT actorID
                                FROM StarsIn
                                WHERE movieID = (SELECT id
                                                 FROM Movies
                                                 WHERE name = '$movie_name')) as Stars
                  WHERE Actors.id = Stars.actorID";

        $result = mysqli_query($db, $query);
    
        print "<b>Movie: </b>" . $movie_name . "<br><b>Stars:</b><ul>";
        while($row = mysqli_fetch_assoc($result)) {
             print "<li>" . utf8_encode($row["name"]) . "</li>";
        }
        print "</ul>";
        mysqli_close($db);

        //If there is a user logged in, allow them to add the movie to their likes
        if(isset($_SESSION["userID"])) {
            print "<form method=\"POST\" action=\"add_like.php\">
                   <input type=\"text\" class=\"invisible\" name=\"movie\" value=\"$movie_name\" readonly>
                   <input type=\"submit\" value=\"Add to likes\">
                   </form>
            ";
        }
    }
?>
<button onclick="visitSearch()">Back to search</button>
</body>

</html>