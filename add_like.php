<?php 
    session_start();
?>

<!DOCTYPE html>
<head>
    <style>
        html {
            background-color: #dfdfdf;
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
    $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");

    $movieName = $_POST["movie"];
    $userID = $_SESSION["userID"];

    $query = "INSERT INTO Likes(userID, movieID)
              SELECT '$userID' as userID, 
              (SELECT id FROM Movies WHERE name = '" . utf8_decode($movieName) ."') as movieID";

    if(mysqli_query($db, $query)) {
        print("Successfully updated your likes!");
    }
    else {
        print("Could not update your likes.<br>Maybe you've already added that movie?<br>Maybe you misspelled the movie's name?");
    }

    mysqli_close($db);
    ?>

    <button onclick = "returnHome()">Home</button>
</body>
</html>