<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Гостевая книга</title>
</head>
<body>
<?php
include 'Validator.php';
require 'sortLinkTh.php';
require 'CheckFileFormat.php';

$connection = new mysqli('localhost', 'root', '', 'guestbook');
$validator = new Validate\Validator();
$errors = [];


if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message-text'])) {
    print_r($_POST);
    print_r($_FILES);
    $errors = checkFileFormat($_FILES);
    if (count($errors) === 0) {
        $name = $validator->validate($_POST['name']);
        $email = $validator->validate($_POST['email']);
        $homepage = $validator->validate($_POST['homepage']);
        $messageText = $validator->validate($_POST['message-text']);
        $userAgent = $validator->validate($_SERVER['HTTP_USER_AGENT']);
        $ipAddress = ip2long($_SERVER['REMOTE_ADDR']);
        $result = $connection->query("INSERT INTO `guests` (name, email, homepage, text, user_agent, ip_address) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress')");

        if ($result) {
            $successMessage = 'Это было классно!';
        } else {
            $failedMessage = 'Ой, что-то пошло не так!';
        }
    }
}

$sort_list = [
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
];
if (count($_GET) === 0) {
    $sort = '';
} else {
    $sort = $_GET['sort'];
}
if (array_key_exists($sort, $sort_list)) {
    $sort_sql = $sort_list[$sort];
} else {
    $sort_sql = reset($sort_list);
}
?>
    <main class="main">
        <div class="container">
            <div class="form-container">
                <?php if (isset($successMessage)) { ?><div class="alert alert-success" role="alert"> <?php echo $successMessage?> </div> <?php } ?>
                <?php if (isset($failedMessage)) { ?><div class="alert alert-danger" role="alert"> <?php echo $failedMessage?> </div> <?php } ?>
                <?php foreach($errors as $error) { ?><div class="alert alert-danger" role="alert"><?php echo $error ?></div> <?php } ?>
                <form enctype="multipart/form-data" action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name (required field)" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com (required field)" required>
                    </div>
                    <div class="mb-3">
                        <label for="homepage" class="form-label">Homepage</label>
                        <input type="url" class="form-control" name="homepage" id="homepage" placeholder="https://example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                        <textarea class="form-control" name="message-text" id="exampleFormControlTextarea1" placeholder="Your text (required field)" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Add file</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                        <input class="form-control" type="file" id="formFile" name="user-file">
                    </div>
                    <div class="btn-container">
                        <button type="submit" id="btn-form" class="btn btn-primary btn-lg">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped" id="table">
                <tr>
                    <th scope="col" class="count"><?php echo sortLinkTh('№', 'date_direct', 'date_reverse')?></th>
                    <th scope="col" class="user_name"><?php echo sortLinkTh('Name', 'name_direct', 'name_reverse')?></th>
                    <th scope="col" class="e_mail"><?php echo sortLinkTh('E-mail', 'email_direct', 'email_reverse')?></th>
                    <th scope="col" class="homepage"><?php echo sortLinkTh('Homepage', 'homepage_direct', 'homepage_reverse')?></th>
                    <th scope="col" class="message_text"><?php echo sortLinkTh('Text', 'text_direct', 'text_reverse')?></th>
                </tr>
                    <?php
                    $query = "SELECT * FROM `guests` ORDER BY {$sort_sql}";
                    $dbData = $connection->query($query)->fetch_all( MYSQLI_ASSOC);
                    $countDb = count($dbData);
                    for ($i = 0; $i < count($dbData); $i += 1) { ?>
                <tr>
                    <td>
                        <?php if($sort_sql === '`id` DESC') {
                            echo $countDb;
                            $countDb--;
                        } else {
                            echo $i + 1;
                        }?>
                    </td>
                    <td>
                        <?php echo $dbData[$i]['name']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$i]['email']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$i]['homepage']; ?>
                    </td>
                    <td>
                        <?php echo $dbData[$i]['text']; ?>
                    </td>
                </tr>
                    <?php } ?>
            </table>
        </div>
    </main>
</body>
</html>