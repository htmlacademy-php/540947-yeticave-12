<?php

require('init.php');

$search = trim($_GET['search'] ?? '');

if (isset($search)) {
    //Текущая страница
    $cur_page = $_GET['page'] ?? 1;
    //Число лотов на странице
    $page_item = 9;
    //Узнаем общее число лотов
    $lot_count = "SELECT COUNT(*) as cnt
                    FROM lot
                    WHERE date_end > NOW() AND MATCH(name_lot, description_lot) AGAINST(?)";

    $stmt = db_get_prepare_stmt($mysqli, $lot_count, [$search]);
    $stmt->execute();
    $result = $stmt->get_result();
    $lot_item = $result->fetch_assoc()['cnt'];

    //Считаем общее количество страниц
    $page_count = ceil($lot_item / $page_item);
    //Смещение записей
    $offset = ($cur_page - 1) * $page_item;
    //Заполняем массив номерами всех страниц
    $pages = range(1, $page_count);

    //Формируем запрос на показ 9 новых лотов
    $show_new_lot = "SELECT * FROM lot
                    JOIN category c ON category_id = c.id
                    WHERE date_end > NOW() AND MATCH(name_lot, description_lot) AGAINST(?)
                    ORDER BY dt_add DESC
                    LIMIT $page_item
                    OFFSET $offset";

    $stmt = db_get_prepare_stmt($mysqli, $show_new_lot, [$search]);
    $stmt->execute();
    $result = $stmt->get_result();
    $search_final = $result->fetch_all(MYSQLI_ASSOC);
}

//HTML-код главной страницы
$search_content = include_template('search_temp.php',
    [
        'search' => $search,
        'categories' => $all_categories,
        'pages' => $pages,
        'cur_page' => $cur_page,
        'lots' => $search_final
    ]
);

//HTML-код всей страницы
$layout_content = include_template('layout.php',
    [
        'main_content' => $search_content,
        'title' => 'Результаты поиска',
        'categories' => $all_categories,
        'search' => $search
    ]
);

print($layout_content);
