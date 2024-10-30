<?php

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    if(isset($_POST['action']) && $_POST['action'] == 'session')
    {
        // Start Session
        if(session_id() == '')  
        {
            session_start();
        }

        if(!isset($_SESSION["customer"]))
        {
            $_SESSION["customer"]["id"] = "";
        }

        echo json_encode($_SESSION["customer"]);
    }
}