<?php
require 'session.php';
$_SESSION['user_id'] = NULL;
$_SESSION['type'] = NULL;
header('Location: /index.php');