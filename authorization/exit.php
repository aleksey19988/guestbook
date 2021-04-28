<?php
include '../Cookies.php';

$cookies = new Cookies();
$cookies->delCookie('user');

header('Location: ../index.php');