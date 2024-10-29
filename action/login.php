<?php

require_once '../class/Member.php';

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $member = new Member();

    $data = $_POST;

    $result = $member->login($data);

    if(isset($result["customer"]))
    {
        $customer = $result["customer"];

        // Start Session
        if(session_id() == '')  
        {
            session_start();
        }

        $_SESSION["customer"] = $customer;

        unset($result["customer"]);
    }

    echo json_encode($result);
}