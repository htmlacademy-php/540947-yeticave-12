<?php
date_default_timezone_set("Europe/Moscow");
require_once('helpers.php');

$is_auth = rand(0, 1);

$user_name = 'Богдан'; // укажите здесь ваше имя

//Подключаемся к MySql
$mysqli = new mysqli("127.0.0.1", "root", "", "yeticave13");

//Установка кодировки
$mysqli->set_charset("utf8mb4");

//Проверка подключения 
if ($mysqli->connect_error) {
    error_log('Ошибка при подключении: ' . $mysqli->connect_error);
}

//Выполнение запроса на показ новых лотов
$show_new_lot = $mysqli->query("SELECT l.id, l.name_lot, l.start_price, l.img_path, MAX(b.final_price) total_price, c.title, l.date_end 
                            FROM lot l
                                INNER JOIN bet b ON l.id = b.lot_id
                                INNER JOIN category c ON l.category_id = c.id
                            WHERE l.date_end > NOW()
                            GROUP BY b.lot_id");

//Получение записей в виде ассоциативного массива
$new_lot = $show_new_lot->fetch_all(MYSQLI_ASSOC);

//Выполнение запроса на показ категорий
$show_categories = $mysqli->query("SELECT * 
                                FROM category");

//Получение категорий в виде массива
$all_categories = $show_categories->fetch_all(MYSQLI_ASSOC);

//Проверка исполнения запроса
if ($mysqli->connect_error) {
    error_log('Ошибка при подключении: ' . $mysqli->connect_error);
}

//HTML-код главной страницы
$page_content = include_template('main.php', ['categories' => $all_categories, 'advertisement' => $new_lot]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Интернет-аукцион «YetiCave»', 'user_name' => 'Богдан', 'categories' => $all_categories, 'is_auth' => $is_auth]);

print($layout_content);



