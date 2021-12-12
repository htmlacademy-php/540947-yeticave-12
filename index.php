<?php
date_default_timezone_set("Europe/Moscow");
require_once('helpers.php');
require_once('init.php');

$is_auth = rand(0, 1);

$user_name = 'Богдан'; // укажите здесь ваше имя

//Выполнение запроса на показ новых лотов
$show_new_lot = $mysqli->query("SELECT l.id, l.name_lot, l.start_price, l.img_path, c.title, l.date_end
                            FROM lot l
                                JOIN category c ON l.category_id = c.id
                            WHERE l.date_end > NOW()
                            ORDER BY l.dt_add DESC
                            LIMIT 6");

//Получение записей в виде ассоциативного массива
$new_lot = $show_new_lot->fetch_all(MYSQLI_ASSOC);

//HTML-код главной страницы
$page_content = include_template('main.php', ['categories' => $all_categories, 'advertisement' => $new_lot]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Интернет-аукцион «YetiCave»', 'user_name' => $user_name, 'categories' => $all_categories, 'is_auth' => $is_auth]);

print($layout_content);



