<?php
$is_auth = rand(0, 1);
require_once('helpers.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
else {
  http_response_code(404);
  exit();
}


$mysqli = new mysqli("127.0.0.1", "root", "", "yeticave13");

$mysqli->set_charset("utf8mb4");
 
if ($mysqli->connect_error) {
    error_log('Ошибка при подключении: ' . $mysqli->connect_error);
}

$show_lot = "SELECT l.name_lot, l.start_price, l.img_path, l.bet_step, l.description_lot, c.title, c.title_id, l.date_end 
                            FROM lot l
                                JOIN category c ON l.category_id = c.id
                            WHERE l.id = ?";
$stmt = $mysqli->prepare($show_lot);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$lot = $result->fetch_all(MYSQLI_ASSOC);

if (!$lot) {
  http_response_code(404);
  exit();
}

//Выполнение запроса на показ категорий
$show_categories = $mysqli->query("SELECT * 
                                FROM category");

//Получение категорий в виде массива
$all_categories = $show_categories->fetch_all(MYSQLI_ASSOC);

//HTML-код главной страницы
$lot_content = include_template('lot_temp.php', ['lot_info' => $lot, 'category' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $lot_content, 'title' => 'Интернет-аукцион «YetiCave»', 'user_name' => 'Богдан', 'categories' => $all_categories, 'is_auth' => $is_auth]);

print($layout_content);
