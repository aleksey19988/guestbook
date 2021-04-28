<?php
include 'Validator.php';
include 'sortLinkTh.php';
include 'CheckFileFormat.php';
include 'Request.php';
include 'Cookies.php';

$request = new Request();
$cookies = new Cookies();

$connection = new mysqli('localhost', 'root', '', 'guestbook');
$validator = new Validate\Validator();
$fileFormatErrors = [];


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

//Алгоритм для генерации страниц

$perPage = 25;//Сколько строк должно быть на странице
$rows = $connection->query("SELECT * FROM `guests`")->fetch_all(MYSQLI_ASSOC);// считаем сколько всего строк
$currentPage = 0;
if ($request->getQuery('page') && $request->getQuery('page') > 0) {
    $currentPage = $request->getQuery('page');
}
$pages = ceil(count($rows) / $perPage);//Делим общее кол-во строк на кол-во строк на странице, чтобы понять сколько нужно страниц
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Гостевая книга</title>
</head>
<body>
    <div class="preview" id="preview">
        <div class="preview_message">
            <div class="preview_message_container">
                <h3>Предварительный просмотр &#127748;</h3>
                <br>
                <table class="table table-striped preview_content">
                    <tr class="header">
                        <th>№</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Homepage</th>
                        <th>Text</th>
                        <th>Date and time</th>
                        <th>File</th>
                    </tr>
                    <tr class="message_content" id="message_content">

                    </tr>
                </table>
                <div class="preview_buttons">
                    <button class="btn btn-primary btn-lg" type="submit" form="form" formaction="" formmethod="post" id="saveMessage">Мне всё нравится, сохраняем!</button>
                    <button class="btn btn-primary btn-lg" type="button" id="btn_edit_message">Вернуться</button>
                </div>
                <div class="close_button" id="close_button_preview"></div>
            </div>
        </div>
    </div>
    <div class="preview preview_without_required_fields" id="preview_without_required_fields">
        <div class="preview_message">
            <div class="preview_message_container">
                <h3>Информация &#127748;</h3>
                <br>
                <p class="information_text">
                    Сначала нужно заполнить все обязательные поля
                </p>
                <div class="preview_buttons">
                    <button class="btn btn-primary btn-lg" type="button" id="btn_add_required_values">Вернуться</button>
                </div>
                <div class="close_button" id="close_button"></div>
            </div>
        </div>
    </div>
    <div class="success-save-message">
        <div class="success-save-message-container">
            <h3 class="success-save-message-container-header">Отлично! &#127881;</h3>
            <p class="success-save-message-container__text">Сообщение успешно добавлено</p>
            <button type="button" class="btn btn-primary btn-lg success-save-message-container__button">Класс</button>
            <div class="success-save-message-close_button" id="close_button"></div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="nav-elem">
                <div class="header-links">
                    <a class="navbar-brand" href="#">Guestbook</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Разные</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">классные</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">но нерабочие</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">кнопки</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if(!empty($cookies->getCookie('user'))): ?>
                <div class="log-out-container">
                    <div class="user">Привет, <?= $cookies->getCookie('user')?></div>
                    <button type="button" class="btn btn-primary log-in-btn">
                        <a href="authorization/exit.php" class="log-in-btn__text">Выйти</a>
                    </button>
                </div>
                <?php else: ?>
                <div class="navbar-buttons">
                    <button type="button" class="btn btn-primary log-in-btn">
                        <a href="authorization/login/register.html" class="log-in-btn__text">Зарегистрироваться</a>
                    </button>
                    <button type="button" class="btn btn-primary sign-in-btn">
                        <a href="authorization/signIn/sign-in.php" class="sign-in-btn__text">Войти</a>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <div class="form-container">
                <div class="info-messages"></div>
                <fieldset>
                    <legend>Оставь свой комментарий!</legend>
                    <form enctype="multipart/form-data" action="" method="POST" id="my-form" class="my-form" name="upload">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" class="form-control name" name="name" placeholder="Name (required field)" required onkeyup="handleChange();">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address*</label>
                            <input type="email" class="form-control email" name="email" placeholder="name@example.com (required field)" required onkeyup="handleChange();">
                        </div>
                        <div class="mb-3">
                            <label for="homepage" class="form-label">Homepage</label>
                            <input type="url" class="form-control homepage" name="homepage" placeholder="https://example.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Text*</label>
                            <textarea class="form-control text" name="message" id="exampleFormControlTextarea1" placeholder="Your text (required field)" rows="3" required onkeyup="handleChange();"></textarea>
                        </div>
                        <input type="hidden" name="date_and_time" class="date_and_time" id="date_and_time" value="<?= date('Y-m-d H:i:s') ?>">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Add file</label>
                            <input class="form-control" type="file" id="formFile" name="user_file" onchange="previewFile();">
                            <div class="image-preview" id="imagePreview">
                                <img src="" alt="Image preview" class="image-preview__image">
                                <span class="image-preview__default-text">Image preview</span>
                                <div class="del-button" id="deleteFileButton" onclick="deleteImage();"></div>
                            </div>
                        </div>
                        <div class="btn-container">
                            <button type="submit" id="btn-form" class="btn btn-primary btn-lg" disabled>Add</button>
                            <button type="button" id="btn-preview" class="btn btn-primary btn-lg" disabled>Preview</button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <div class="container-fluid table-search">
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success table-search__button" type="submit" disabled>Search</button>
                <div class="table-search__warning">Поиск пока не реализован. Приносим извинения за доставленные неудобства</div>
            </form>
        </div>
        <div class="container table-container">
            <table class="table table-striped" id="table">
                <tr>
                    <th scope="col" class="count"><?php echo sortLinkTh('№', 'date_direct', 'date_reverse')?></th>
                    <th scope="col" class="user_name"><?php echo sortLinkTh('Name', 'name_direct', 'name_reverse')?></th>
                    <th scope="col" class="e_mail"><?php echo sortLinkTh('E-mail', 'email_direct', 'email_reverse')?></th>
                    <th scope="col" class="homepage"><?php echo sortLinkTh('Homepage', 'homepage_direct', 'homepage_reverse')?></th>
                    <th scope="col" class="message_text"><?php echo sortLinkTh('Text', 'text_direct', 'text_reverse')?></th>
                    <th scope="col" class="date_time"><?php echo sortLinkTh('Date & time', 'datetime_direct', 'datetime_reverse')?></th>
                </tr>
                    <?php
                    $selectRecord = $currentPage * $perPage;
                    $query = "SELECT * FROM `guests` ORDER BY {$sortSql} LIMIT {$selectRecord}, {$perPage}";
                    $dbData = $connection->query($query)->fetch_all( MYSQLI_ASSOC);
                    for ($i = $selectRecord, $j = 0; $i < count($dbData) + $selectRecord; $i += 1, $j += 1) { ?>
                <tr>
                    <td>
                        <?php if($sortSql === '`id` DESC') {
                            echo count($dbData) - $i;
                        } else {
                            echo $i + 1;
                        }?>
                    </td>
                    <td>
                        <?php echo $dbData[$j]['name']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$j]['email']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$j]['homepage']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$j]['text']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$j]['datetime']; ?>
                    </td>
                </tr>
                    <?php } ?>
            </table>
        </div>
        <div class="container">
            <div class="pages">
                <?php for ($i = 1; $i <= $pages; $i += 1): ?>
                    <a href="?page=<?=$i - 1?>" class="page_link"><?= $i ?></a>
                <?php endfor ?>
            </div>
        </div>
    </main>
</body>
<script src="./previewMessage.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="ajax.js"></script>
<script src="enabledButtons.js"></script>
<script src="previewImg.js"></script>
</html>