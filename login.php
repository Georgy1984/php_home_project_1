<?php 

    session_start();
    require "functions.php";
    

    $email=$_POST['email'];
    $password=$_POST['password'];

    
    
    login($email, $password); 
    
    set_flash_message("success", "Successful");

    redirect_to("/project_1/users.php"); 

    

       


    



        
        

        

        


        
            

        





    

    

   



?>