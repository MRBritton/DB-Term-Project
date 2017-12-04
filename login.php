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
            text-align: center;
        }
    </style>
</head>
<?php

    function validateLogin($username, $password) {
        //query the database to find a matching username
        $db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
        $query = "SELECT id FROM Users WHERE username = '$username' AND password = '$password';";
        $result = mysqli_query($db, $query);
        mysqli_close($db);
        
        if(mysqli_num_rows($result) == 0)
            return 0;
        
        if(mysqli_num_rows($result) == 1)
        {
            while($row = mysqli_fetch_assoc($result)) {
                return $row["id"];
            }
        }
            
        else
            return 0;      
    }

    $userID = -1;
    if(isset($_SESSION["userID"])) {
        $userID = $_SESSION["userID"];
    }    
    //Do we have input to handle?
    if(!empty($_POST)) {
        //If someone is logging in
        if(isset($_POST["log_in"])) {
            $un = $_POST["username"];
            $pw = $_POST["password"];
            
            $logged_in = validateLogin($un, $pw);
            if($logged_in) {
                $_SESSION["userID"] = $logged_in;
                print("<p>Successfully logged in!</p>");
            }
            else
                print("<p>Login failed.</p>");    
        }
    }
?>
<button onclick= "returnHome()">Return home
</html>