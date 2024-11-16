<?php

$result = array(
    "success" => false,
    "message" => "",
);

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['action']) && $_POST['action'] == 'logout')
    {
        // Start Session
        if(session_id() == '')  
        {
            session_start();
        }

        unset($_SESSION["customer"]);

        $result["success"] = true;
        $result["message"] = "Logout Success. Wait for 3 seconds to refresh the page.";
    }
}

echo json_encode($result);