<?php
include '../../Cookies.php';

$cookies = new Cookies();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Вход</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="nav-elem">
                <div class="header-links">
                    <a class="navbar-brand" href="../../index.php">Guestbook</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Разные</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">классные</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">но нерабочие</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">кнопки</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="navbar-buttons">
                    <button type="button" class="btn btn-primary log-in-btn">
                        <a href="../login/register.html" class="log-in-btn__text">Зарегистрироваться</a>
                    </button>
                    <button type="button" class="btn btn-primary sign-in-btn">
                        <a href="sign-in.php" class="sign-in-btn__nav__text">Войти</a>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <?php if(empty($cookies->getCookie('user'))): ?>
    <div class="container mt-4">
        <div class="container-content">
            <div class="container-content__form">
                <legend>Скорее входи! &#128591;</legend>
                <div class="info-messages"></div>
                <form method="post" enctype="multipart/form-data" action="" id="signInForm" class="sign-in-form">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@example.com" onkeyup="blockInput();">
                    </div>
                    <p class="word__or">или</p>
                    <div class="mb-3">
                        <label for="nickname" class="form-label">Никнейм</label>
                        <input type="text" class="form-control" name="nickname" id="nickname" placeholder="Действующий никнейм" onkeyup="blockInput();">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Пароль*</label>
                        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="********" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sign-in">Войти</button>
                </form>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container welcome-container mt-4" id="welcome-container">
        <div class="welcome-container-content">
            <h3 class="welcome-header">Здорово! &#127881;</h3>
            <p class="welcome__content">Привет, <?= $_COOKIE['user']?>! Если ты хочешь выйти - жми <a href="../exit.php">здесь</a>.</p>
            <button type="button" class="btn btn-primary btn-add-comment">
                <a href="../../index.php" class="add-comment__text">Оставить комментарий</a>
            </button>
        </div>
    </div>
    <?php endif;?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="signInRequest.js"></script>
<script src="blockInput.js"></script>
</html>
