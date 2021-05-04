<?php
include '../Request.php';

$request = new Request();
$connection = new mysqli('localhost', 'root', '', 'guestbook');
$dateAndTimeCreateMessage = $request->getRequest('dateAndTime');

$result = $connection->query("DELETE FROM comments WHERE datetime = '$dateAndTimeCreateMessage'");

if ($result) {
    echo json_encode(array('result' => 'success'));
} else {
    echo json_encode(array('result' => 'failed'));
}