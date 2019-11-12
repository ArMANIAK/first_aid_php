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

            

                <p style="height: 3px; background-color: rgb(218, 41, 28)"></p>
            </section>
        </nav>

        <main>
            <section title="Товариство Червоного Хреста України">
                <?php 
                    $score = $_SESSION['score'];
                    if(count($_SESSION['questions']) > 0) {
                        $answers = reset($_SESSION['questions']);
                        $question = key($_SESSION['questions']);
                        unset($_SESSION['questions'][$question]); 
                    ?>
                        <h2 class='cntr'> <?php echo $question ?> </h2>
                        <form class="answer-form" action="checker.php" method="post">
                            <input name="question" type="textarea" hidden value="<?php echo $question?>">
                            <?php foreach($answers as $answer) :?>
                                <button name="answer" class="answer" value="<?php echo $answer ?>"><?php echo $answer ?></button>
                            <?php endforeach ?>
                        </form>
                    <?php      
                    } else {
                        require 'database_connect.php';
                        $difficulty = $_SESSION['difficulty'];
                        $checkQuery = $pdo->prepare('SELECT ' . $difficulty . ' FROM users WHERE username = :username');
                        $checkQuery->bindParam(':username', $_SESSION['user_id']);
                        $checkQuery->execute();
                        $result = $checkQuery->fetchAll(PDO::FETCH_ASSOC);

                        $total = $_SESSION['total'];
                        $best = $result[0][$difficulty];
                        echo "<h2 class='cntr'> Ваш результат $score вірних відповідей з $total </h2>";
                        if ($score > $best) {
                            $updateQuery = $pdo->prepare('UPDATE users SET ' . $difficulty . '=' . $score . ' WHERE username = :username');
                            $updateQuery->bindParam(':username', $_SESSION['user_id']);
                            $updateQuery->execute();
                            echo "<h2 class='cntr'> Це Ваш новий найкращий результат! Поздоровляємо! </h2>";
                        } else {
                            echo "<h2 class='cntr'> Ваш найкращий результат $best </h2>";
                        }
                        if ($score / $total < 0.4) {
                            echo "<h2 class='cntr'> Товариство Червоного Хреста України попереджує, що такий низький рівень обізнаності правил надання першої допомоги є небезпечним для будь-кого. 
                            Будь ласка, винайдіть час та пройдіть будь-який тренінг з першої допомоги! </h2>";
                        }
                        elseif ($score / $total > 0.8) {
                            echo "<h2 class='cntr'> Молодець! В більшості кризових ситуацій Ви будете корисним і не завдасте шкоди. Дякуємо Вам! </h2>";
                        } else {
                            echo "<h2 class='cntr'> Хоча Ваш рівень знань у цій галузі досить високий, може треба дещо підновити навички? </h2>";
                        }
                    }
                ?>
            </section>

        </main>

        <footer style="position: fixed; bottom: 0; width: 100%; background-color: rgb(218, 41, 28); padding: 5px; color: white; text-align: center">
            This site is ArMANIAK's cs50 Final Project
        </footer>

    </body>

</html>
