<?php
    require_once './lib/scripts.php';

    if (isset($_COOKIE['date'])) setcookie ("date", "", time() - 3600);

    $userName = $_POST['login']?? '';
    $userPswd = $_POST['password']?? '';
    $message;

    if ($userName !== '' & $userPswd !== '') {
        if (existsUser($userName)) {
            if (checkPassword($userName, $userPswd)) {
                session_start();
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $userName;
                header('Location: index.php');
            } else {
                $message = 'Не верный пароль!';
            }
        } else {
            $message = 'Пользователя не существует! Зарегистрируйтесь!';
        }
    } else {
        $message = 'Вы не заполнили форму!';
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Эстер-SPA</title>
    <link href="./css/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login">
            <p class="login-text">Для входа в личный кабинет SPA-salon авторизуйтесь!</p>
            <form action="" method="post">
                <div class="setting">
                    <input name="login" type="text" placeholder="Логин">
                    <input name="password" type="password" placeholder="Пароль">
                    <button name="submit" type="submit">Войти</button>
                </div>
            </form>
        <?php
            if (isset($_POST['submit'])) {
        ?>
            <div class="pop-up">
                <p><?=$message?></p>
            </div>
        <?php
            }
        ?>
            <p class="login-text"><a href="#">Зарегистрируйтесь!</a></p>
        </div>
    </div>
</body>
</html>