<?php 

    session_start();

    require "functions.php";

    $email=$_POST['email'] ?? null;
    $password=$_POST['password'] ?? null;

    $user=get_user_by_email($email);

        

    if(!empty($user)) {

        set_flash_message("danger", "Этот эл. адрес уже занят другим пользователем");
        redirect_to("/project_1/page_register.php");

        
        
        
    } 
    
    add_user_by_email($email, $password);

    set_flash_message("success", "Вы зареганы");
    redirect_to("/project_1/page_login.php");






?>