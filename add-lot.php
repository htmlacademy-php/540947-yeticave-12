<?php
require ('init.php');
require ('helpers.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$page_content = include_template('add_temp.php', ['categories' => $all_categories]);

//HTML-код всей страницы
$default_layout = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Добавление лота', 'categories' => $all_categories]);

if ($_SERVER ['REQUEST_METHOD'] !== 'POST') {
    print_r($default_layout);
    exit();
}

if ($all_categories) {
    $cats_ids = array_column($all_categories, 'id');
}

$lot = [
    'lot-name' => $_POST['lot-name'],
    'category' => $_POST['category'],
    'message' => $_POST['message'],
    'lot-rate' => is_numeric($_POST['lot-rate']) ? (float)$_POST['lot-rate'] : $_POST['lot-rate'],
    'lot-step' => is_numeric($_POST['lot-step']) ? $_POST['lot-step'] + 0 : $_POST['lot-step'],
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
$errors['lot-img'] = "Файл не загружен";
if (!empty($_FILES['lot-img']['tmp_name'])) {
    unset($errors['lot-img']);
    $tmp_name = $_FILES['lot-img']['tmp_name'];
    $file_name = $_FILES['lot-img']['name'];
    $file_path = __DIR__ . '/uploads/';
    $file_url = '/uploads/' . $file_name;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    $errors['lot-img'] = "Загрузите файл в формате PNG или JPEG";
    if ($file_type == "image/png" || $file_type == "image/jpeg") {
        unset($errors['lot-img']);
        move_uploaded_file($tmp_name, $file_path . $file_name);
        $lot['lot-img'] = $file_url;
    }
}
if (!$errors) {
$sql = "INSERT INTO lot (name_lot, category_id, description_lot, start_price, bet_step, date_end, img_path, users_id, winner_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 2)"; 
$stmt = db_get_prepare_stmt($mysqli, $sql, [$lot['lot-name'], $lot['category'], $lot['message'], $lot['lot-rate'], $lot['lot-step'], $lot['lot-date'], $lot['lot-img'], $_SESSION['user']['users_name']]);
$stmt->execute();
$lot_id = $mysqli->insert_id;
header("Location: lot.php?id=" . $lot_id); 
exit();
}

$page_content = include_template('add_temp.php', ['errors' => $errors, 'categories' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Добавление лота', 'categories' => $all_categories]);

print($layout_content);