<?php
include '../Request.php';

$request = new Request();
$searchText = $request->getRequest('search');

$connection = new mysqli('localhost', 'root', '', 'guestbook');

$sortList = [
    'date_direct' => '`id`',
    'date_reverse' => '`id` DESC',
    'name_direct' => '`name`',
    'name_reverse' => '`name` DESC',
    'email_direct' => '`email`',
    'email_reverse' => '`email` DESC',
    'homepage_direct' => '`homepage`',
    'homepage_reverse' => '`homepage` DESC',
    'text_direct' => '`text`',
    'text_reverse' => '`text` DESC',
    'datetime_direct' => '`datetime`',
    'datetime_reverse' => '`datetime` DESC',
];
if (count($_GET) === 0 || !$request->getQuery('sort')) {
    $sort = '';
} else {
    $sort = $request->getQuery('sort');
}
if (array_key_exists($sort, $sortList)) {
    $sortSql = $sortList[$sort];
} else {
    $sortSql = reset($sortList);
}

$perPage = 25;//Сколько строк должно быть на странице
$rows = $connection->query("SELECT * FROM `comments`")->fetch_all(MYSQLI_ASSOC);// считаем сколько всего строк
$currentPage = 0;
if ($request->getQuery('page') && $request->getQuery('page') > 0) {
    $currentPage = $request->getQuery('page');
}
$pages = ceil(count($rows) / $perPage);//Делим общее кол-во строк на кол-во строк на странице, чтобы понять сколько нужно страниц

$selectRecord = $currentPage * $perPage;
//$query = "SELECT * FROM `comments` ORDER BY {$sortSql} LIMIT {$selectRecord}, {$perPage}";
//$dbData = $connection->query($query)->fetch_all( MYSQLI_ASSOC);


$result = $connection->query("SELECT * FROM comments WHERE text LIKE '%$searchText%' ORDER BY {$sortSql} LIMIT {$selectRecord}, {$perPage}")
    ->fetch_all(MYSQLI_ASSOC);

print_r(json_encode($result));