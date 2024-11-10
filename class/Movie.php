<?php

require_once 'Database.php';

class Movie extends Database
{
    public function getMovieList()
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

        $sql = "SELECT m.*, t.name AS theatre_name, mt.id AS movie_theatre_id, mt.start_time 
        FROM movie_theatre mt 
        JOIN movie m ON m.id = mt.movie_id 
        JOIN theatre t ON t.id = mt.theatre_id
        WHERE 1
        ORDER BY mt.start_time ASC
        ";
        $dbData = parent::fetchAll($pdo, $sql, array());

        $result["success"] = true;
        $result["message"] = $dbData;

        return $result;
    }

    public function getAvailableSeatList($movieTheatreId)
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();
        $sql = "SELECT mt.id AS movie_theatre_id, mt.start_time, s.id AS seat_id, s.line, s.column, r.id AS reservation_id, ri.id AS reservation_item_id 
        FROM movie_theatre mt 
        JOIN seat s ON s.theatre_id = mt.theatre_id
        LEFT JOIN reservation r ON r.movie_theatre_id = mt.id
        LEFT JOIN reservation_item ri ON ri.seat_id = s.id AND ri.reservation_id = r.id
        WHERE mt.id = :id
        ORDER BY s.id ASC
        ";
        $dbData = parent::fetchAll($pdo, $sql, array("id" => $movieTheatreId));

        $result["success"] = true;
        $result["message"] = $dbData;

        return $result;
    }

    public function reservation($data)
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();

        // add record to table
        $sql = "INSERT INTO `reservation`(`customer_id`, `movie_theatre_id`, `total_amount`, `created_at`) VALUES (:customer_id, :movie_theatre_id, :total_amount, NOW())";

        $sqlBindData = array(
            "customer_id" => $data["customer_id"],
            "movie_theatre_id" => $data["movie_theatre_id"],
            "total_amount" => $data["price"]*count($data["seat_id"]),
        );

        $lastInsertId = parent::insertQuery($pdo, $sql, $sqlBindData);

        // update order number
        $orderNumber = "ORDER".str_pad($lastInsertId, 7, "0", STR_PAD_LEFT);

        $sql = "UPDATE `reservation` SET order_number = :order_number WHERE id = :id";

        $sqlBindData = array(
            "order_number" => $orderNumber,
            "id" => $lastInsertId,
        );

        $rowCount = parent::updateQuery($pdo, $sql, $sqlBindData);

        // add ticket record to table
        foreach ($data["seat_id"] as $seatId) 
        {
            $sql = "INSERT INTO `reservation_item`(`reservation_id`, `seat_id`) VALUES (:reservation_id, :seat_id)";

            $sqlBindData = array(
                "reservation_id" => $lastInsertId,
                "seat_id" => $seatId,
            );

            parent::insertQuery($pdo, $sql, $sqlBindData);
        }

        $result["success"] = true;
        $result["message"] = "Reservation Success. You can enjoy the movie now.";

        return $result;
    }
}