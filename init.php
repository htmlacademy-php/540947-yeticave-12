<?php

session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db = require 'connect_db.php';

//Подключаемся к MySql
$mysqli = new mysqli(
    $db['db']['host'],
    $db['db']['username'],
    $db['db']['password'],
    $db['db']['dbname'],
    $db['db']['port']
);

//Установка кодировки
$mysqli->set_charset($db['db']['charset']);

//Проверка подключения
if ($mysqli->connect_error) {
    error_log('Ошибка при подключении: ' . $mysqli->connect_error);
}

//Выполнение запроса на показ категорий
$show_categories = $mysqli->query(
    "SELECT * FROM category"
);

//Получение категорий в виде массива
$all_categories = $show_categories->fetch_all(MYSQLI_ASSOC);
