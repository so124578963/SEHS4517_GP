<?php

require_once 'Database.php';

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
                "password" => md5($data["password"]),
                "mailing_address" => $data["mailing_address"],
                "phone_number" => $data["phone_number"],
            );

            $lastInsertId = parent::insertQuery($pdo, $sql, $sqlBindData);

            $result["success"] = true;
            $result["message"] = "Member Register Success. You can login the account on Login Page.";
        }

        return $result;
    }

    public function login($data)
    {
        $result = array(
            "success" => false,
            "message" => "",
        );

        // db connect
        $pdo = parent::getConnection();

        // check email address exist
        $sql = "SELECT * FROM customer WHERE email_address = :email_address AND password = :password";
        $dbData = parent::fetchOne($pdo, $sql, array("email_address" => $data["email_address"], "password" => md5($data["password"])));

        if($dbData)
        {
            $customer = $dbData;

            // Login Success
            $sql = "UPDATE `customer` SET last_login_at = NOW() WHERE id = :id;";

            $rowCount = parent::updateQuery($pdo, $sql, array("id" => $customer["id"]));
            
            $result["success"] = true;
            $result["customer"] = $customer;
            $result["message"] = "Login Success: Wait for 5 second to go to Reservation page.";
        }
        else
        {
            $result["message"] = "Login Fail: Account Exist, you can go back to Home Page";
        }

        return $result;
    }
}