<?php 

session_start();

$userID = 8;

$db = mysqli_connect("db1.cs.uakron.edu:3306", "mrb182", "cai5viCu", "ISP_mrb182");
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
    
    
    AND
    
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


    if(!$result) print ("bad");

    mysqli_close($db);
?>