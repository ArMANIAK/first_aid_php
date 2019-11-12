<?php
require 'session.php';
require 'login_require.php';
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

        <title>Тест</title>

    </head>

    <body>
        <header style="margin: 0px">
            <p style="background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">(044) 235-01-57      Національний комітет - 01004, Київ, вул. Пушкінська, 30</p>
            <a class="blank_link" href="https://redcross.org.ua/"><img style="margin: 15px;" width="120px" height="120px" src="/static/logo.jpg" alt="URCS logo"></a>
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
                <form action="quiz.php" method="post">
                    <select class="form-input" name="difficulty">
                        <option value='easy'>Легко</option>
                        <option value='medium'>Середньо</option>
                        <option value='hard'>Складно</option>
                    </select>
                    <button class="form-input" type="submit">Оберіть рівень</button>
                </form>
                
                <?php else:
                $difficulty = $_POST['difficulty'];
                require 'database_connect.php';
                if ($difficulty === 'easy') {
                    $_SESSION['difficulty'] = 'easy';
                    $querryString = "SELECT * FROM questions WHERE difficulty='easy'";
                } elseif ($difficulty === 'medium') {
                    $_SESSION['difficulty'] = 'medi';
                    $querryString = "SELECT * FROM questions WHERE difficulty<>'hard'";
                } else {
                    $_SESSION['difficulty'] = 'hard';
                    $querryString = "SELECT * FROM questions";
                }
                $query = $pdo->prepare($querryString);
                $execution_result = $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $rightAnswers = array();
                $questions = array();
                $i = 0;
                foreach ($result as $task) {
                    $rightAnswers[$task['question']] = $task['right_ans'];
                    $answers = array();
                    array_push($answers, $task['right_ans'], $task['wrong1'], $task['wrong2'], $task['wrong3']);
                    shuffle($answers);
                    $questions[$task['question']] = $answers;
                }
                //shuffle($questions);
                $_SESSION['questions'] = $questions;
                $_SESSION['answers'] = $rightAnswers;
                $_SESSION['score'] = 0;
                $_SESSION['total'] = count($rightAnswers);
                header('Location: test.php');
                endif ?>

                <p style="height: 3px; background-color: rgb(218, 41, 28)"></p>
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
