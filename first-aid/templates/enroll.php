<?php  
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

require 'session.php';

?>

<!DOCTYPE html>

<html lang="ua-UA">

    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- documentation at http://getbootstrap.com/docs/4.1/, alternative themes at https://bootswatch.com/ -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

        <!-- https://favicon.ico -->
        <link href="/static/favicon.ico" rel="icon">

        <link href="/static/styles.css" rel="stylesheet">

        <!-- Font Roboto -->
        <link href="https://fonts.googleapis.com/css?family=Roboto%3A500" rel="stylesheet" property="stylesheet" type="text/css" media="all" />

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <title>Перша допомога</title>

    </head>

    <body>
        <header style="margin: 0px">
            <p style="background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">(044) 235-01-57      Національний комітет - 01004, Київ, вул. Пушкінська, 30</p>
            <a href="https://redcross.org.ua/"><img style="margin: 15px;" width="120px" height="120px" src="/static/logo.jpg" alt="URCS logo"></a>
            <h1>Товариство Червоного Хреста України</h1>
        </header>

        <nav style="text-align: right">
            <section>
            <?php if (isset($_SESSION['user_id'])): ?>
            <ul>
                        <li><a href="/templates/quiz.php">Тест</a></li>
                        <li><a href="/templates/result.php">Результати</a></li>
                        <li><a href="/templates/enroll.php">Запишіть мене</a></li>

                        <?php if ($_SESSION['type'] != 0): ?>
                            <li><a href="/templates/registrants.php">Зареєстровані</a></li>
                        <?php endif ?>

                        <li><a href="/templates/logout.php">Вийти</a></li>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li><a href="/templates/register.php">Зареєструватися</a></li>
                        <li><a href="/templates/login.php">Увійти</a></li>
                    </ul>
                <?php endif ?>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
                <form action="enroll.php" method="post">
                    <input autocomplete="off" autofocus class="form-input" name="contacts" size="100" placeholder="Введіть Вашу контактну інформацію (телефон або електронну скриньку)" type="text">
                    <select class="form-input" name="type">
                        <option value='MK' selected>Майстер-клас</option>
                        <option value='6hour'>Шостигодинний тренінг</option>
                        <option value='12hour'>Дванадцятигодинний тренінг</option>
                        <option value='48hour'>Сорокавосьмигодинний тренінг</option>
                    </select>
                    <button class="form-input" type="submit">Зареєструватись</button>
                </form>
                
                <?php else:
                $username = $_SESSION['user_id'];
                $contact_data = $_POST['contacts'];
                $course_type = $_POST['type'];
                require 'database_connect.php';
                $query = $pdo->prepare('INSERT INTO registrants (username, course_type, contact_data) VALUES (:username, :course_type, :contact_data)');
                $query->bindParam(':username', $username);
                $query->bindParam(':course_type', $course_type);
                $query->bindParam(':contact_data', $contact_data);
                $execution_result = $query->execute();
                
                endif ?>

                <p style="height: 3px; background-color: red"></p>
            </section>
        </nav>

        <main>
            <article style="margin: 15px">
                <section title="Товариство Червоного Хреста України">
                    <h2>
                        Товариство Червоного Хреста України
                    </h2>
                    <p style="text-align:left">Історія Товариства Червоного Хреста України сягає більш ніж на 100 років назад.</p>
                </section>

                <section title="Перша допомога">
                    <h2>
                        Перша допомога
                    </h2>
                    <p style="text-align:left">Хоча ми і не дуже часто опиняємося в кризових ситуаціях, краще бути готовим заздалегідь</p>
                </section>

                <section title="Про проект">
                    <h2>
                        Про проект
                    </h2>
                    <p style="text-align:left">Тести запроваджені Товариством Червоного Хреста України. Матеріали відповідають сертифікованій програмі</p>
                </section>
            </article>

        </main>

        <footer style="position: fixed; bottom: 0; width: 100%; background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">
            This site is ArMANIAK's cs50 Final Project
        </footer>

    </body>

</html>
