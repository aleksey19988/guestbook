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
$connection = mysqli_connect('localhost', 'root', '');
$select_db = mysqli_select_db($connection, 'guestbook');

function validator($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if (isset($_POST['name']) && isset($_POST['email']) && $_POST['message-text']) {
    $name = validator($_POST['name']);
    $email = validator($_POST['email']);
    $homepage = validator($_POST['homepage']);
    $messageText = validator($_POST['message-text']);
    $query = "INSERT INTO guests (name, email, homepage, messageText) VALUES ('$name', '$email', '$homepage', '$messageText')";
    var_dump($query);
    $result = mysqli_query($connection, $query);
    var_dump($result);

    if ($result) {
        $successMessage = 'Сообщение добавлено!';
    } else {
        $failedMessage = 'Исправьте даннные в соответствии с требованиями!';
    }
}
?>
    <main>
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
                <tr>
                    <th>№</th>
                    <th>User Name</th>
                    <th>E-mail</th>
                    <th>Homepage</th>
                    <th>Text</th>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>