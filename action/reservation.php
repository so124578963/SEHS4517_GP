<?php

require_once '../class/Movie.php';

// customer reservation
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $movie = new Movie();

    $data = $_POST;

    $result = $movie->reservation($data);

    echo json_encode($result);
}