<?php

require_once '../class/Movie.php';

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['action']) && $_POST['action'] == 'movie_list')
    {
        $movie = new Movie();

        $result = $movie->getList();

        echo json_encode($result);
    }
}