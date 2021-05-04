<?php
include '../Request.php';

$request = new Request();
$now = new DateTime();

$connection = new mysqli('localhost', 'root', '', 'guestbook');
$updateMessageText = $request->getRequest('edit-message-input');
$dateAndTime = $request->getRequest('dateAndTime');
$editDateAndTime = $now->format('Y-m-d H:i:s');

$result = $connection->query("UPDATE comments SET text = '$updateMessageText', editDateAndTime = '$editDateAndTime' WHERE datetime = '$dateAndTime'");

if ($result) {
    echo json_encode(array('result' => 'success'));
} else {
    echo json_encode(array('result' => 'failed'));
}