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
                <form action="login.php" method="post">
                    <input autocomplete="off" autofocus class="form-input" name="username" placeholder="Username" type="text">
                    <input class="form-input" name="password" placeholder="Password" type="password">
                    <button class="form-input" type="submit">Come on</button>
                </form>
                
                <?php else:
                $username = $_POST['username'];
                $pass_hash = md5($_POST['password']);
                require 'database_connect.php';
                $query = $pdo->prepare('SELECT * FROM users WHERE username = :username');
                $query->bindParam(':username', $username);
                $execution_result = $query->execute();
                if ($execution_result === TRUE) {
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (!empty($result)) {
                        
                        if ($result[0]['pass_hash'] === $pass_hash) {
                            $_SESSION['user_id'] = $username;
                            $_SESSION['type'] = $result[0]['moderator'];
                            header('Location: /index.php');
                        } else {
                            $_SESSION['apology_code'] = 111;
                            $_SESSION['apology_message'] = 'ERROR: INCORRECT PASSWORD';
                            header('Location: /templates/apology.php');
                        }                    

                    } else {
                        $_SESSION['apology_code'] = 111;
                        $_SESSION['apology_message'] = 'ERROR: LOGIN WAS NOT FOUND';
                        header('Location: /templates/apology.php');
                    }
                    // $_SESSION['apology_code'] = 502;
                    // $_SESSION['apology_message'] = 'ERROR: SOMETHING WENT WRONG';
                    // header('Location: /templates/apology.php');
                }

                endif ?>

            <script>

                document.querySelector('form').onsubmit = function() {
                if (!document.querySelector('input[name = "username"]').value) {
                    alert('You must provide your name!');
                    return false;
                }
                else if (!document.querySelector('input[name = "password"]').value) {
                    alert('You must provide your password!');
                    return false;
                }

                return true;
                };

            </script>
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
