<?php
    $dbName = 'quiz';
    $dbUser = 'root';
    $dbPass = '';
    $pdo = new PDO("mysql:host=localhost; dbname=$dbName", $dbUser, $dbPass);
    $pdo->exec("set names utf8");
?>