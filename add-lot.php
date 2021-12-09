<?php
require ('init.php');
require ('helpers.php');

$is_auth = rand(0, 1);

$user_name = 'Богдан';


if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    if ($all_categories) {
        $cats_ids = array_column($all_categories, 'id');
    }

    $lot = [
        'lot-name' => $_POST['lot-name'],
        'category' => $_POST['category'],
        'message' => $_POST['message'],
        'lot-rate' => $_POST['lot-rate'],
        'lot-step' => intval($_POST['lot-step']),
        'lot-date' => $_POST['lot-date'],
        'lot-img' => $_FILES['lot-img'],
    ];
    $required_items = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date', 'lot-img'];
    $errors = [];

    $rules = [
        'category' => function($value) use ($cats_ids) {
            return validateCategoryId($value, $cats_ids);
        },
        'lot-rate' => function($value) {
            return validateStartPrice($value);
        },
        'lot-step' => function($value) {
            return validateStep($value);
        },
        'lot-date' => function($value) {
            return validateDate($value);
        },
    ];
// Валидация формы и проверка на заполняемость по обязательным полям
$errors = form_validation($lot, $rules, $required_items);

//Отфильтровываем массив с ошибками, удаляя пустые значения
$errors = array_filter($errors);

//Проверка загружен ли файл, правильный ли его тип и перенос файла с временного хранилища в постоянное
if (!empty($_FILES['lot-img']['tmp_name'])) {
    $tmp_name = $_FILES['lot-img']['tmp_name'];
    $file_name = $_FILES['lot-img']['name'];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
        $errors['lot-img'] = "Загрузите файл в формате PNG или JPEG";
    }
    else {
        move_uploaded_file($tmp_name, $file_path . $file_name);
        $lot['lot-img'] = $file_url;
    }
}
else {
    $errors['lot-img'] = "Вы не загрузили файл";
}

if (count($errors)) {
    $page_content = include_template('add_temp.php', ['errors' => $errors, 'categories' => $all_categories]);
}
else {
    $sql = "INSERT INTO lot (name_lot, category_id, description_lot, start_price, bet_step, date_end, img_path, users_id, winner_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1, 2)"; 
    $stmt = db_get_prepare_stmt($mysqli, $sql, [$lot['lot-name'], $lot['category'], $lot['message'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $lot['lot-img']]);
    $stmt->execute();

    if ($stmt) {
        $lot_id = $mysqli->insert_id;

        header("Location: lot.php?id=" . $lot_id);
        exit();
    }
}
}

$page_content = include_template('add_temp.php', ['categories' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Добавление лота', 'user_name' => $user_name, 'categories' => $all_categories, 'is_auth' => $is_auth]);

print($layout_content);