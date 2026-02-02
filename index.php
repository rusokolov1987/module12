<?php
    require_once './lib/scripts.php';
    session_start();
    $auth = $_SESSION['auth']?? null;
    $login = getCurrentUser();

    $exit = $_GET['exit']?? null;

    if ($exit) {
        session_destroy();
        header('Location: login.php');
    }

    if ($auth) {
        $date = $_POST['date']?? '';
        if ($date) {
            setcookie(name: 'date', value: $date);
            header('Location: index.php');
        }
        if (!isset($_COOKIE['time'])) {    
            $currentTime = time();
            setcookie(name: 'time', value: $currentTime);
        }
        $currentDate = date('Y-m-d');
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SPA "Розовый Понь"</title>
        <link href="./css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <header class="header">
                <div class="user-info">
                    <p>Добро пожаловать, <b><?=$login?></b>!</p>
                </div>
                <nav class="menu">
                    <ul class="menu-items">
                        <li class="item"><a href="#about">О нас</a></li>
                        <li class="item"><a href="#services">Наши услуги</a></li>
                        <li class="item"><a href="#stock">Наши акции</a></li>
                        <li class="item"><a href="#contact">Контакты</a></li>
                    </ul>
                </nav>
                <div class="exit">
                    <form action="login.php" method="get">
                        <button type="submit" name="exit">Выход</button>
                    </form>
                </div>
            </header>

            <div class="welcome">
                <h1 class="welcome-title">Добро пожаловать в SPA салон "Розовый Понь"!</h1>
            </div>

            <section class="sales" id="sales">
                <p class="section-title">Ваши персональные скидки!</p>
            <?php
                if (!isset($_COOKIE['date'])) {
            ?>
                <div class="info-block">
                    <form method="post">
                        <div class="setting">
                            <p>Введите вашу дату рождения:</p>
                            <input name="date" type="date">
                            <button name="set" type="submit">Сохранить!</button>
                        </div>
                    </form>
                </div>
            <?php
                } else {
                    $days = getDayToBirthday($_COOKIE['date']);
                    if ($days == 0) {
            ?>
                <div class="info-block">
                    <p class="sale-birthday">Поздравляем с Днём Рождения! Дарим вам скидку на все услуги 5%!</p>
                </div>
            <?php
                    } else {
            ?>
                <div class="info-block">
                    <p class="sale-birthday">До вашего дня рождения осталось...<?=$days?> дней!</p>
                </div>
            <?php
                    }
                }
            ?>
                <div class="info-block">
                    <p class="sale-personal">Вам доступна персональная скидка в 20 %. Закончится через:
                
            <?php
                if (isset($_COOKIE['time'])) {
                    $entryTime = $_COOKIE['time'];
                    $date = explode('-', date('Y-m-d', $entryTime));
                    $time = explode(':', date('H:i:s', $entryTime));
                    $date[2] += 1;
                    $diff = date_diff(new DateTime($date[0].'-'.$date[1].'-'.$date[2].' '.$time[0].':'.$time[1].':'.$time[2]), new DateTime(date('Y-m-d H:i:s', time())));
            ?>
                    <span><?=$diff->h?> ч. <?=$diff->i?> м. <?=$diff->s?> с.</span></p>
                </div>
            <?php
                }
            ?>
            </section>

            <section class="about" id="about">
                <div>
                    <p class="section-title">Немного о нас!</p>
                </div>
                <div class="about-info">
                    <div class="foto">

                    </div>
                    <div class="about-text">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis voluptates numquam distinctio nesciunt doloribus vero neque quae ea voluptas, nisi sunt voluptatibus accusamus dolorum ratione ullam provident quasi nulla hic.
                        Sit nostrum quasi et ea. Eveniet soluta dolores consectetur, corrupti numquam laborum pariatur hic maiores veniam in nostrum et quo recusandae. Aspernatur corporis similique distinctio assumenda totam, autem inventore nihil.
                        Molestiae expedita eveniet odio placeat eligendi culpa ut quae illum voluptates quod distinctio, non mollitia quas. Asperiores rerum nobis aut. Accusantium reprehenderit excepturi incidunt? Voluptates sapiente recusandae nostrum voluptas quos?
                        Necessitatibus culpa aspernatur, quidem facilis labore iusto numquam aliquam fugit atque doloribus nesciunt eos quae cumque exercitationem assumenda voluptatum repudiandae tenetur aperiam maxime quam debitis soluta odio. Necessitatibus, sed labore.
                        Assumenda cupiditate eos nesciunt ipsa dolorem odit eaque molestiae consectetur asperiores inventore minus, quisquam numquam laudantium, repellat amet expedita praesentium at rem! Aliquam commodi temporibus reprehenderit laudantium autem. Perspiciatis, at?
                        Quod quidem magnam facere aspernatur commodi fugit odit atque architecto iure expedita nesciunt ad minus beatae quam, quas reprehenderit vel eligendi molestias non ipsum. Saepe molestiae accusamus pariatur dignissimos quod.
                        Sapiente itaque similique commodi, placeat assumenda debitis quas reprehenderit asperiores beatae officiis delectus perferendis deserunt non fuga sit perspiciatis! Nihil molestiae quae at doloribus repellat vel, omnis sequi porro unde.
                        Velit, nemo. Eum sit est fugiat nisi harum voluptas, sint ipsum quisquam error nesciunt, repellat adipisci laudantium obcaecati quos? Quo ea maxime velit magni vero dolorum magnam soluta quas unde.
                        Non, repellat. Voluptatibus labore tempora temporibus, fugiat officiis aspernatur placeat adipisci autem magni officia, illum quod. Id distinctio tempore veniam aut! Veritatis veniam eaque blanditiis saepe velit! Maiores, veniam cupiditate!
                        Reiciendis, voluptate tenetur. Nihil fugiat ratione a vero optio minima, aliquid blanditiis omnis nisi, voluptate reiciendis? Enim doloremque sit praesentium, eveniet perspiciatis in itaque dolore veniam vel, nemo eaque aspernatur.
                    </div>
                </div>
            </section>

            <section class="services" id="services">
                <div>
                    <p class="section-title">Наши услуги!</p>
                </div>
                <div class="services-list">
                    <ul class="list">
                        <li class="service"><a href="#">SPA-процедуры для волос.</a></li>
                        <li class="service"><a href="#">SPA-процедуры для лица.</a></li>
                        <li class="service"><a href="#">SPA-процедуры для рук.</a></li>
                        <li class="service"><a href="#">SPA-процедуры для ног.</a></li>
                        <li class="service"><a href="#">SPA-процедуры для тела.</a></li>
                        <li class="service"><a href="#">Комплексные SPA-программы.</a></li>
                    </ul>
                </div>
            </section>

            <section class="stocks" id="stock">
                <div>
                    <p class="section-title">Наши акции!</p>
                </div>

                <div class="stock-list">
                    <ul class="list">
                        <li class="stock">Скидка ко дню рождения в 5%</li>
                        <li class="stock">Персональная скидка!</li>
                        <li class="stock">Первый из первых!</li>
                    </ul>
                </div>
            </section>

            <section class="contacts" id="contact">
                <div>
                    <p class="section-title">Как нас найти!</p>
                </div>
                <div class="contact-info">
                    <ul class="list">
                        <li class="contact">Место: Страна Розовых Понь, город Гламурнск, ул. Гламурная д. 1</li>
                        <li class="contact">Телефон: +3(333) 33-33-33</li>
                        <li class="contact">Email: pink_ponies@ponis.com</li>
                    </ul>
                </div>
            </section>
            <footer class="footer">
                <p>SPA-салон "Розовый Понь" &copy; <?=date('Y');?></p>
            </footer>
        </div>
    </body>
    </html>
<?php
    } else {
?>
    <a href="login.php">Страница не доступна! Авторизуйтесь, пожалуйста!</a>
<?php
    session_destroy();
    }
?>