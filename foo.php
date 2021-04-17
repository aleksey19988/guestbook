<?php
include 'Validator.php';
include 'Request.php';
include 'CheckFileFormat.php';

$request = new Request();

$connection = new mysqli('localhost', 'root', '', 'guestbook');
$validator = new Validate\Validator();
$fileFormatErrors = [];

if ($request->getRequest('name') && $request->getRequest('email') && $request->getRequest('message')) {
    $fileFormatErrors = 0;//checkFileFormat($request->getFiles());//Смотрим, соответствует ли формат прикреплённого файла заданным параметрам

    if ($fileFormatErrors === 0) {
        $name = $validator->validate($request->getRequest('name'));
        $email = $validator->validate($request->getRequest('email'));
        $homepage = $validator->validate($request->getRequest('homepage'));
        $messageText = $validator->validate($request->getRequest('message'));
        $userAgent = $validator->validate($request->userAgent());
        $ipAddress = $validator->validate($request->getIpAddress());
        $datetime = date('Y-m-d H:i:s');
        $result = $connection->query("INSERT INTO `guests` (name, email, homepage, text, user_agent, ip_address, datetime) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress', '$datetime')");

//        if ($result) {
//            $successMessage = 'Это было классно!';
//        } else {
//            $failedMessage = 'Ой, что-то пошло не так!';
//        }
        if ($result) {
            echo json_encode(array('success' => 1));
        } else {
            echo json_encode(array('success' => 0));
        }
    }
}