<?php
include 'Validator.php';
include 'Request.php';
include 'CheckFileFormat.php';
include 'Cookies.php';

$request = new Request();
$now = new DateTime();
$validator = new Validate\Validator();
$cookies = new Cookies();


$connection = new mysqli('localhost', 'root', '', 'guestbook');
$fileFormatErrors = [];

$fileFormatErrors = checkFileFormat($request->getFiles());//Смотрим, соответствует ли формат прикреплённого файла заданным параметрам

if ($fileFormatErrors['result'] === 'success') {
    $name = $validator->validate($request->getRequest('name'));
    $email = $validator->validate($request->getRequest('email'));
    $homepage = $validator->validate($request->getRequest('homepage'));
    $messageText = $validator->validate($request->getRequest('message'));
    $userAgent = $validator->validate($request->userAgent());
    $ipAddress = $validator->validate($request->getIpAddress());
    $datetime = $now->format('Y-m-d H:i:s');

    if ($cookies->getCookie('userNickname')) {
        $userNickName = $cookies->getCookie('userNickname');
        $connectionUsersDb = new mysqli('localhost', 'root', '', 'users_db');
        $userId = $connectionUsersDb->query("SELECT * FROM users WHERE nickname = '$userNickName'")->fetch_assoc()['id'];
        $result = $connection->query("INSERT INTO `comments` (name, email, homepage, text, user_agent, ip_address, datetime, user_id) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress', '$datetime', '$userId')");
    } else {
        $result = $connection->query("INSERT INTO `comments` (name, email, homepage, text, user_agent, ip_address, datetime) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress', '$datetime')");
    }


    if ($result) {
        echo json_encode(array('result' => 'success'));
    } else {
        echo json_encode(array('result' => 'failed'));
    }
} else {
    echo json_encode($fileFormatErrors);
}

$connection->close();
