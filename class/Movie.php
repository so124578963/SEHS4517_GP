<?php

require_once 'Database.php';

class Movie extends Database
{
    public function getList()
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();

        // check email address exist
        $sql = "SELECT * FROM movie WHERE 1";
        $dbData = parent::fetchAll($pdo, $sql, array());

        $result["success"] = true;
        $result["message"] = $dbData;

        return $result;
    }

    public function getTheatreList()
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();

        // check email address exist
        $sql = "SELECT m.*, t.name AS theatre_name, mt.id AS movie_theatre_id, mt.start_time FROM movie_theatre mt 
        JOIN movie m ON m.id = mt.movie_id 
        JOIN theatre t ON t.id = mt.theatre_id
        WHERE 1
        ";
        $dbData = parent::fetchAll($pdo, $sql, array());

        $result["success"] = true;
        $result["message"] = $dbData;

        return $result;
    }
}