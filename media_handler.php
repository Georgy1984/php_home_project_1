<?php 

    session_start();
    require_once "functions.php";

    $currentUser = get_user_by_id($_SESSION['user']['id']);
    if ($currentUser['role'] != 'admin' && $_POST['id'] != $currentUser['id']) {
        echo 'Доступ запрещен';
        die();
    }
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        display_flash_message("error", "Не верный id");
        redirect_to("/project_1/login.php");
    }

    $id = $_POST['id'];
    $avatar = $_FILES['image'];




    userAvatar($id, $avatar);

    redirect_to("users.php");

    




?>