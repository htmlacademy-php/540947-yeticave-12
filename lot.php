<?php
require_once('helpers.php');
require_once('init.php');

$id = $_GET['id'] ?? null;
if (!$id) {
http_response_code(404);
exit();
}

$show_lot = "SELECT l.name_lot, l.start_price, l.img_path, l.bet_step, l.description_lot, c.title, c.title_id, l.date_end 
                            FROM lot l
                                JOIN category c ON l.category_id = c.id
                            WHERE l.id = ?";
$stmt = db_get_prepare_stmt($mysqli, $show_lot, [$id]);
$stmt->execute();
$result = $stmt->get_result();
$lot = $result->fetch_all(MYSQLI_ASSOC);

if (!$lot) {
  http_response_code(404);
  exit();
}

//HTML-код главной страницы
$lot_content = include_template('lot_temp.php', ['lot_info' => $lot, 'category' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $lot_content, 'title' => 'Интернет-аукцион «YetiCave»', 'categories' => $all_categories]);

print($layout_content);
