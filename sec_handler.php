<?php 


session_start();
require_once "functions.php";

$userId = $_POST['id'];
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;


edit_credentials($userId, $email, $password);

redirect_to("users.php");







?>