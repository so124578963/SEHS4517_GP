<?php

require_once '../class/Movie.php';

// get movie list
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['action']) && $_POST['action'] == 'movie_list')
    {
        $movie = new Movie();

        $result = $movie->getMovieList();

        echo json_encode($result);
    }
}