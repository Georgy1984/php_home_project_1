<?php
require_once "config.php";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    //$conn = new PDO("mysql:host=$servername; dbname=myDB", $username, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

function get_user_by_email($email)
{

    global $pdo;
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function set_flash_message($name, $message)
{

    $_SESSION[$name] = $message;

}

function redirect_to($path)
{

    header("Location: {$path}");
    exit;
}

function add_user($email, $password, $username = null, $job_title = null, $status = null, $image = null, $phone = null, $address = null, $telegram = null, $instagram = null, $vk = null)
{

    global $pdo;
    $sql = "INSERT INTO users SET `email`=:email, `username`=:username, `job_title`=:job_title, `status`=:status, `image`=:image, " .
        "`phone`=:phone, `vk`=:vk, `address`=:address, `telegram`=:telegram, `instagram`=:instagram,  `password`=:password";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT), "username" => $username, "job_title" => $job_title,
        "status" => $status, "image" => $image, "phone" => $phone, "vk" => $vk, "address" => $address, "telegram" => $telegram, "instagram" => $instagram]);

    return $pdo->lastInsertId();
}

function add_user_by_email($email, $password)
{
    global $pdo;
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)]);

    return $pdo->lastInsertId();
}

function display_flash_message($name)
{
    if (isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
    }

    unset ($_SESSION[$name]);
}

function login($email, $password)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($user)) {
        set_flash_message("error", "Не верный логин или пароль");
        redirect_to("/project_1/page_login.php");
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        set_flash_message("error", "Не верный логин или пароль");
        redirect_to("/project_1/page_login.php");
        exit;
    }

    $_SESSION['user'] = $user;
}

function get_users()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_authenticated_user()
{
    if (is_logged_in()) {
        return $_SESSION['user'];
    }

    return false;
}

function is_logged_in()
{
    if (isset($_SESSION['user'])) {
        return true;
    }

    redirect_to("/project_1/login.php");
}


function is_not_logged_in()
{
    return !is_logged_in();
}

function is_admin($user)
{
    if (is_logged_in()) {
        if ($user["role"] === "admin") {
            return true;
        }

        return false;
    }
}

function is_equal($user, $current_user)
{
    if ($user["id"] == $current_user["id"]) {
        return true;
    }

    return false;
}

function edit(int $id, string $username, string $job_title, string $phone, string $address, string $status)
{
    global $pdo;
    $sql = "UPDATE `users` SET `username` = :username, `job_title` = :job_title, `phone` = :phone , `address` = :address, `status` = :status WHERE `id`= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["username" => $username, "job_title" => $job_title, "phone" => $phone, "address" => $address, "id" => $id, "status" => $status]);
}

function get_user_by_Id(int $id)
{
    global $pdo;

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id" => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function edit_credentials(int $id, string $email, string $password) 
{

    global $pdo;
    $sql = "UPDATE `users` SET `email` = :email, `password` = :password WHERE `id`= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT), "id" => $id]);

}

function status_changer(int $id, string $status) 
{

    global $pdo;
    $sql = "UPDATE `users` SET  `status` = :status WHERE `id`= :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["status" => $status, "id" => $id]);

}


function userAvatar($id, $image) 
{
    global $pdo;


        //var_dump($image); exit;
        $result = pathinfo($image['name']); 
        $fileName = $id  . '-' . uniqid() . "." .$result['extension'];

        //C:/OSPanel/domains/testhost
        move_uploaded_file($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] .'/project_1/upload_avatar/'. $fileName); //почитать про DOCUMENT_ROOT подробнее

        
        $sql = "UPDATE `users` SET  `image` = :image WHERE `id`= :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["image" => $fileName, "id" => $id]); 
        
    
        
}


function logout() {

    unset($_SESSION['user']);
    
    redirect_to("page_login.php");
}
