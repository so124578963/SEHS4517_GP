<?php

require_once '../class/Member.php';

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $member = new Member();

    $data = $_POST;

    $result = $member->register($data);

    echo json_encode($result);
}