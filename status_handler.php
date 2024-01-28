<?php 

    session_start();
    require_once "functions.php";


    $userId = $_POST['id'];
    $status = $_POST['status'];


    status_changer($userId, $status);

    redirect_to("users.php");


?>