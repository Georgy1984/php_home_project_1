<?php 

session_start();
require_once "functions.php";

is_logged_in();
//$_SESSION['user']
// id = 15 */! сделал для себя как пример. Разобраться более детально с тернарными операторами**
//$id = $_SESSION['user']['role'] == 'admin' ? $_GET['id'] : $_SESSION['id'];

/*
if ($_SESSION['user']['role'] == 'admin') {
    $id = $_GET['id'];
    $user = get_user_by_Id($id);
} else {
    $user = get_user_by_Id($_SESSION['user']['id']);
}
*/
$currentUser = get_user_by_id($_SESSION['user']['id']);
/*if ($currentUser['role'] == 'admin') {
    $id = $_GET['id'];
    $user = get_user_by_Id($id);
} else {
    $user = get_user_by_Id($_SESSION['user']['id']);
}*/
if ($currentUser['role'] != 'admin' && $_GET['id'] != $currentUser['id']) {
    echo 'Доступ запрещен';
    die();
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    display_flash_message("error", "Не верный id");
    redirect_to("/project_1/login.php");
}
$user = get_user_by_Id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="users.php"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="page_login.php">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Редактировать
            </h1>

        </div>
        <form action="/project_1/edit_handler.php" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Общая информация</h2>
                            </div>
                            <div class="panel-content">
                                <!-- username -->
                                <div class="form-group">
                                    <label class="form-label" for="simpleinput">Имя</label>
                                    <input type="text" name="username" id="simpleinput" class="form-control" value="<?= $user['username'] ?>">
                                </div>

                                <!-- title -->
                                <div class="form-group">
                                    <label class="form-label" for="job_title">Место работы</label>
                                    <input type="text" name="job_title" id="job_title" class="form-control" value="<?=  $user['job_title'] ?>">
                                </div>

                                <!-- tel -->
                                <div class="form-group">
                                    <label class="form-label" for="phone">Номер телефона</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="<?=  $user['phone'] ?>">
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <label class="form-label" for="address">Адрес</label>
                                    <input type="text" name="address" id="address" class="form-control" value="<?=  $user['address'] ?>">
                                </div>
                                <div class="form-group">
                                     <label class="form-label" for="pet-select">Choose a status:</label>

                                    <select class="form-control" name="status" id="pet-select">
                                        <option value="">--Выберите статус--</option>
                                        <option value="online" <?php if ($user['status'] == 'online'): ?> selected <?php endif ?>>Online</option>
                                        <option value="offline" <?php if ($user['status'] == 'offline'): ?> selected <?php endif ?>>Offline</option> 
                                        
                                    </select>

                                </div>

                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Редактировать</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</body>
</html>