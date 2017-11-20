<?php
    session_start();
?>

<!DOCTYPE html>
<head>
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
    </script>
</head>
<!--- ALSO SEARHC BY YEAR AND LIST OF MOVIES WITH FAVORITE ACTOR-->
<body>
    <p>Search movies by rating</p>
    <form action="search.php" method="POST">
        <input type="text" name="rating" id="rating" value="5.0" onblur="validateRating()">Rating<br>
        <input type="radio" name="comp" value="equal_to">Equal to<br>
        <input type="radio" name="comp" value="less_than">Less than<br>
        <input type="radio" name="comp" value="greater_than">Greater than<br>
        <input id="search-btn" type="submit" value="Search"><div id="error-msg"></div>
    </form>


    <?php
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
        $query = "SELECT name, rating, releaseYear FROM Movies WHERE rating";

        $comparison = $_POST["comp"];
        $rating = $_POST["rating"];

        if($comparison == "equal_to") 
            $query = $query . " = ";
        elseif($comparison == "less_than")
            $query = $query . " <= ";
        elseif($comparison == "greater_than")
            $query = $query . " >= ";
        
        $query = $query . $rating;

        $result = mysqli_query($db, $query);

        
        while($row = mysqli_fetch_assoc($result)) {
            //output as a table
        }


        mysqli_close($db, $query);

    ?>
</body>
</html>