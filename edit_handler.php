<?php 

        session_start();

        require_once "functions.php";


        

        $userId = $_POST['id'];
        $username = $_POST['username'] ?? null;
        $job_title = $_POST['job_title'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;
        $status = $_POST['status'] ?? null;

        


        edit($userId, $username, $job_title, $phone, $address, $status);
        set_flash_message("success", "Профиль успешно обновлен");

        redirect_to("users.php");





        

        


      

        



        

        

    

?>