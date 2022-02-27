<?php

require ('init.php');

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}

//Текущая страница
$cur_page = $_GET['page'] ?? 1;
//Число лотов на странице
$page_items = 9;
//Узнаем общее число лотов по категориям
$lot_category_count = "SELECT COUNT(*) as cnt
                FROM lot l
                JOIN category c ON l.category_id = c.id
                WHERE l.date_end > NOW() AND c.id = ?";

$stmt = db_get_prepare_stmt($mysqli, $lot_category_count, [$category_id]);
$stmt->execute();
$result = $stmt->get_result();
$lot_category_items = $result->fetch_assoc()['cnt'];

//Показ заголовка категории
$category_lot = "SELECT DISTINCT title FROM category
                WHERE id = ?";

$stmt = db_get_prepare_stmt($mysqli, $category_lot, [$category_id]);
$stmt->execute();
$result = $stmt->get_result();
$category_title_final = $result->fetch_assoc();


//Считаем общее количество страниц
$page_count = ceil($lot_category_items / $page_items);
//Смещение записей
$offset = ($cur_page - 1) * $page_items;
//Заполняем массив номерами всех страниц
$pages = range(1, $page_count);

//Формируем запрос на показ 9 лотов одной категории
$show_category_lot = "SELECT * FROM lot l
                JOIN category c ON l.category_id = c.id
                WHERE l.date_end > NOW() AND c.id = ?
                ORDER BY l.dt_add DESC
                LIMIT $lot_category_items
                OFFSET $offset";

$stmt = db_get_prepare_stmt($mysqli, $show_category_lot, [$category_id]);
$stmt->execute();
$result = $stmt->get_result();
$lot_items_final = $result->fetch_all(MYSQLI_ASSOC);


//HTML-код главной страницы
$lot_category_content = include_template('all_lots_temp.php', ['categories' => $all_categories, 'pages' => $pages, 'cur_page' => $cur_page, 'lots_items' => $lot_items_final, 'category_title' => $category_title_final]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $lot_category_content, 'title' => 'Все лоты', 'categories' => $all_categories]);

print($layout_content);