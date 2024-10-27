<?php

class Member extends Database
{
    public function register($data)
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();

        // check email address exist
        $sql = "SELECT * FROM customer WHERE email_address = :email_address";
        $dbData = parent::fetchAll($pdo, $sql, array("email_address" => $data["email_address"]));

        if(count($dbData) > 0)
        {
            // email address already exist
            $result["message"] = "Email Address Already Exist.";
        }
        else
        {
            // add record to table
            $sql = "INSERT INTO `customer`(`first_name`, `last_name`, `email_address`, `password`, `mailing_address`, `phone_number`, `created_at`, `is_active`) VALUES (:first_name, :last_name, :email_address, :password, :mailing_address, :phone_number, NOW(), 1)";

            $sqlBindData = array(
                "first_name" => $data["first_name"],
                "last_name" => $data["last_name"],
                "email_address" => $data["email_address"],
                "password" => $data["password"],
                "mailing_address" => md5($data["mailing_address"]),
                "phone_number" => $data["phone_number"],
            );

            $lastInsertId = parent::insertQuery($pdo, $sql, $sqlBindData);

            $result["success"] = true;
            $result["message"] = "Member Register Success.";
        }

        return $result;
    }
}