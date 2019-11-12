<?php
    require 'session.php';
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    if ($_SESSION['answers'][$question] === $answer) {
        $_SESSION['score']++;
    }
    header('Location: test.php');
?>