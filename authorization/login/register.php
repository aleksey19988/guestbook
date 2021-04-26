<?php

use Validate\Validator;

include '../../Validator.php';
include '../../Request.php';

$request = new Request();
$validator = new Validator();

$connection = new mysqli('localhost', 'root', '', 'users_db');

$email = $validator->validate($request->getRequest('email'));
$password =  md5($validator->validate($request->getRequest('password')));//хэшируем пароль для защиты
$name = $validator->validate($request->getRequest('name'));
$nickname = $validator->validate($request->getRequest('nickname'));

$result = $connection->query("INSERT INTO `users` (email, password, name, nickname) VALUES ('$email', '$password', '$name', '$nickname')");

if ($result) {
    echo json_encode(array('result' => 'success'));
} else {
    echo json_encode(array('result' => 'failed'));
}
