<?php

use Validate\Validator;

include '../../Validator.php';
include  '../../Request.php';
include '../../Cookies.php';

$validator = new Validator();
$request = new Request();
$cookies = new Cookies();

$connection = new mysqli('localhost', 'root', '', 'users_db');

$email = $request->getRequest('email');
$nickname = $request->getRequest('nickname');
$password = md5($request->getRequest('password'));

if (!empty($email)) {
    $result = $connection->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
} else {
    $result = $connection->query("SELECT * FROM users WHERE nickname = '$nickname' AND password = '$password'");
}
$user = $result->fetch_assoc();

if (empty($user)) {
    echo json_encode(array(
        'result' => 'failed',
        'error' => 'Такой пользователь не найден',
    ));
} else {
    $cookies->setCookie('user', $user['name']);
    echo json_encode(array(
        'result' => 'success',
        'name' => "{$user['name']}",
    ));
}


$connection->close();