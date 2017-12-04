<?php
    session_start();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cinematch">
    <style>
        html {
            background-color: #dfdfdf;
        }
        
        .invisible {
            opacity: 0;
        }
    </style>
    <script>
        function validateRating() {
            var rating = parseFloat(document.getElementById("rating").value);
            var searchBtn = document.getElementById("search-btn");
            var errMsg = document.getElementById("error-msg");
            if(rating < 1 || rating > 10) {
                searchBtn.disabled = true;
                errMsg.innerHTML = "The rating must be between 1 and 10.";
            }
            else {
                searchBtn.disabled = false;
                errMsg.innerHTML = "";
            }
        }

        function returnHome() {
            window.location = "cinematch.php";
        }
    </script>
</head>
<!--- ALSO SEARHC BY YEAR AND LIST OF MOVIES WITH FAVORITE ACTOR-->
<body>
    <div style="float:left; padding-left: 30px; padding-bottom: 5px; padding-right: 25px;">
    <p>Search movies by rating</p>
    <form action="search.php" method="POST">
        <input type="text" name="rating" id="rating" onblur="validateRating()"> Rating<br>
        <!--<input type="radio" name="comp" value="equal_to">Equal to<br>-->
        <input type="radio" name="comp" value="less_than">Less than<br>
        <input type="radio" name="comp" value="greater_than">Greater than<br>
        <input type="submit" value="Search" name="search_by_rating">
        
    </form>
    </div>

    <div style="float:left;">
        <p>Search movies by name</p>
        <form action="search.php" method="post">
            <input style="margin-bottom: 5px;" type="text" name="movie_name" required> Name<br>
            <input type="submit" value="Search" name="search_by_name">
        </form>
    </div>
    <div style="clear:both;" id="error-msg"></div>
    <hr style="clear:both;">

    

    <?php
    if(!empty($_POST)) {
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
        if(isset($_POST["search_by_rating"])){
            if(isset($_POST["comp"]) && isset($_POST["rating"])) {
            
            $query = "SELECT name, rating, releaseYear FROM Movies WHERE rating";

            $comparison = $_POST["comp"];
            $rating = $_POST["rating"];

            if($comparison == "equal_to")  //THIS SHOULDN'T EVER HAPPEN
                $query = $query . " = ";
            elseif($comparison == "less_than")
                $query = $query . " <= ";
            elseif($comparison == "greater_than")
                $query = $query . " >= ";
            
            $query = $query . number_format($rating, 1);
            $result = mysqli_query($db, $query);
            }
        }
        elseif(isset($_POST["search_by_name"])) {
            $query = "SELECT name, rating, releaseYear FROM Movies WHERE name LIKE '%" . $_POST["movie_name"] . "%'";
        }

        $result = mysqli_query($db, $query);          

            print("<table align=\"center\"><caption>Movies(" . mysqli_num_rows($result) . ")</caption>");
            print("<caption>Click the \"?\" next to any movie for more info.</caption>");
            print("<tr><th>Name</th><th>Rating</th><th>Release year</th></tr>");
            while($row = mysqli_fetch_assoc($result)) {
                print("<tr><td>" . utf8_encode($row["name"]) . "</td><td>" . $row["rating"] . "</td><td>" . $row["releaseYear"] . "</td>");
                //print a hidden unwritable form to send the data if the user wants more info
                print("<td><form method=\"POST\" action=\"info.php\">
                           <input type=\"text\" name=\"movie\" class=\"invisible\" value=\"" . $row["name"] . "\" readonly>
                           <input type=\"submit\" value=\"?\"></form></td></tr>");
            }
            


            mysqli_close($db);
        
    }
    ?>

<button onclick="returnHome()">Back</button><br>
</body>
</html>