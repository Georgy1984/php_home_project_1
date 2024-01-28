<?php 

session_start();
require_once "functions.php";

$email=$_POST['email'] ?? null;
$password=$_POST['password'] ?? null;
$username=$_POST['username'] ?? null;
$job_title=$_POST['job_title'] ?? null;
$status=$_POST['status'] ?? null;
$image=$_POST['image'] ?? null;
$phone=$_POST['phone'] ?? null;
$vk=$_POST['vk'] ?? null;
$address=$_POST['address'] ?? null;
$telegram=$_POST['telegram'] ?? null;
$instagram=$_POST['instagram'] ?? null;

//get_user_by_email($email);

if (empty(get_user_by_email($email))) 
    {
    
    add_user($email, $password, $username, $job_title, $status, $image, $phone, $vk, $address, $telegram, $instagram);
    set_flash_message("success", "Пользователь добавлен");
    redirect_to("create_user.php"); 

    }

    else {

        set_flash_message("error", "Пользователь с таким мылом уже существует");
        redirect_to("create_user.php");


    }






















?>