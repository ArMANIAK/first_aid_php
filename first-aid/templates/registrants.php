<?php
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
        <link href="../static/favicon.ico" rel="icon">

        <link href="../static/styles.css" rel="stylesheet">

        <!-- Font Roboto -->
        <link href="https://fonts.googleapis.com/css?family=Roboto%3A500" rel="stylesheet" property="stylesheet" type="text/css" media="all" />

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <title>Зареєстровані особи</title>

    </head>

    <body>
        <header style="margin: 0px">
            <p style="background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">(044) 235-01-57      Національний комітет - 01004, Київ, вул. Пушкінська, 30</p>
            <a class="blank_link" href="https://redcross.org.ua/"><img style="margin: 15px;" width="120px" height="120px" src="../static/logo.jpg" alt="URCS logo"></a>
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

                <p style="height: 3px; background-color: red"></p>
            </section>
        </nav>

        <main>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if($_SESSION['type'] != 1) {
                    $_SESSION['apology_code'] = 403;
                    $_SESSION['apology_message'] = 'FORBIDDEN';
                    header('Location: /templates/apology.php');
                }
                require 'database_connect.php';
                $query = $pdo->prepare('SELECT * FROM registrants WHERE completed != 1');
                $execution_result = $query->execute();
                if ($execution_result === TRUE) {
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (empty($result)): ?>

                    <h2> Немає жодного запису </h2>

                    <?php else: ?>

                    <section title="Зареєстровані на тренінги">
                        <h2 class="cntr" style="text-align: center">
                            Люди, що зареєструвались на тренінги ТЧХУ
                        </h2>
                        <table class="cntr">
                            <thead>
                                <tr>
                                    <th>Ім'я</th>
                                    <th>Контактні дані</th>
                                    <th>Тип тренінгу</th>
                                    <th>Зареэстровано</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $res) : ?>
                                <tr>
                                    <td> <?php echo $res['username'] ?> </td>
                                    <td> <?php echo $res['contact_data'] ?> </td>
                                    <td> <?php echo $res['course_type'] ?> </td>
                                    <td> <?php echo $res['time_stamp'] ?> </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </section>

                <?php endif;
                }
            } ?>

        </main>

        <footer style="position: fixed; bottom: 0; width: 100%; background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">
            This site is ArMANIAK's cs50 Final Project
        </footer>

    </body>

</html>
