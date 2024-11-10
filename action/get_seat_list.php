<?php

require_once '../class/Movie.php';

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['action']) && $_POST['action'] == 'seat_list')
    {
        $movie = new Movie();

        $result = $movie->getAvailableSeatList($_POST["movie_theatre_id"]);

        echo json_encode($result);
    }
}