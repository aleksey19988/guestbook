<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Гостевая книга</title>
</head>
<body>
<?php
include 'Validator.php';

$connection = new mysqli('localhost', 'root', '', 'guestbook');
$validator = new Validate\Validator();

if (isset($_POST['name']) && isset($_POST['email']) && $_POST['message-text']) {
    $name = $validator->validate($_POST['name']);
    $email = $validator->validate($_POST['email']);
    $homepage = $validator->validate($_POST['homepage']);
    $messageText = $validator->validate($_POST['message-text']);
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $ipAddress = ip2long($_SERVER['REMOTE_ADDR']);
    $result = $connection->query("INSERT INTO `guests` (name, email, homepage, text, user_agent, ip_address) VALUES ('$name', '$email', '$homepage', '$messageText', '$userAgent', '$ipAddress')");

    if ($result) {
        $successMessage = 'Это было классно!';
    } else {
        $failedMessage = 'Ой, ошибочка!';
    }
}
?>
    <main class="main">
        <div class="container">
            <div class="form-container">
                <?php if (isset($successMessage)) { ?><div class="alert alert-success" role="alert"> <?php echo $successMessage?> </div> <?php } ?>
                <?php if (isset($failedMessage)) { ?><div class="alert alert-danger" role="alert"> <?php echo $failedMessage?> </div> <?php } ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="homepage" class="form-label">Homepage</label>
                        <input type="url" class="form-control" name="homepage" id="homepage" placeholder="https://example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                        <textarea class="form-control" name="message-text" id="exampleFormControlTextarea1" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Add file</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <div class="btn-container">
                        <button type="submit" id="btn-form" class="btn btn-primary btn-lg">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped">
                <tr scope="row">
                    <th scope="col">№</th>
                    <th scope="col">User Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Homepage</th>
                    <th scope="col">Text</th>
                </tr>
                    <?php
                    $db_data = $connection->query("SELECT * FROM `guests`")->fetch_all( MYSQLI_ASSOC);
                    for ($i = 0; $i < count($db_data); $i += 1) { ?>
                <tr scope="row">
                    <td scope="col">
                        <?php echo $i + 1; ?>
                    </td>
                    <td scope="col">
                        <?php echo $db_data[$i]['name']; ?>
                    </td>
                    <td scope="col">
                        <?php echo $db_data[$i]['email']; ?>
                    </td>
                    <td scope="col">
                        <?php echo $db_data[$i]['homepage']; ?>
                    </td>
                    <td scope="col">
                        <?php echo $db_data[$i]['text']; ?>
                    </td>
                </tr>
                    <?php } ?>
            </table>
        </div>
    </main>
</body>
</html>