<?php

use Validate\Validator;

include '../../Validator.php';
include '../../Request.php';
include 'RegistrationCheck.php';

$request = new Request();
$validator = new Validator();
$registrationCheck = new RegistrationCheck();

$connection = new mysqli('localhost', 'root', '', 'users_db');

$email = $registrationCheck->isHaveValueInDb($connection, 'users', 'email', $validator->validate($request->getRequest('email')));
if (is_array($email)) {
    echo json_encode($email);
    exit();
}
$password = $registrationCheck->checkPassword($validator->validate($request->getRequest('password')));
if (is_array($password)) {
    echo json_encode($password);
    exit();
}
$name = $validator->validate($request->getRequest('name'));
$nickname = $registrationCheck->isHaveValueInDb($connection, 'users', 'nickname', $validator->validate($request->getRequest('nickname')));
if (is_array($nickname)) {
    echo json_encode($nickname);
    exit();
}
$password =  md5($password);//хэшируем пароль для защиты
$result = $connection->query("INSERT INTO `users` (email, password, name, nickname) VALUES ('$email', '$password', '$name', '$nickname')");

if ($result) {
    echo json_encode(array('result' => 'success', 'name' => "{$name}"));
} else {
    echo json_encode(array('result' => 'failed'));
}

$connection->close();
