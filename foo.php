<?php
include 'Validator.php';
include 'Request.php';
include 'CheckFileFormat.php';

$request = new Request();
$now = new DateTime();
$validator = new Validate\Validator();


$connection = new mysqli('localhost', 'root', '', 'guestbook');
$fileFormatErrors = [];

if ($request->getRequest('name') && $request->getRequest('email') && $request->getRequest('message')) {
    $fileFormatErrors = checkFileFormat($request->getFiles());//Смотрим, соответствует ли формат прикреплённого файла заданным параметрам

    if ($fileFormatErrors['result'] === 'success') {
        $name = $validator->validate($request->getRequest('name'));
        $email = $validator->validate($request->getRequest('email'));
        $homepage = $validator->validate($request->getRequest('homepage'));
        $messageText = $validator->validate($request->getRequest('message'));
        $userAgent = $validator->validate($request->userAgent());
        $ipAddress = $validator->validate($request->getIpAddress());
        $datetime = $now->format('Y-m-d H:i:s');
        $result = $connection->query("INSERT INTO `guests` (name, email, homepage, text, user_agent, ip_address, datetime) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress', '$datetime')");

        if ($result) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'failed'));
        }
    } else {
        echo json_encode($fileFormatErrors);
    }
}