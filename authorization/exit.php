<?php
include '../Cookies.php';

$cookies = new Cookies();
$cookies->delCookie('userName');
$cookies->delCookie('userNickname');
$cookies->delCookie('userId');
$cookies->delCookie('userEmail');

header('Location: ../index.php');