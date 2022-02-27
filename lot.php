<?php

require_once('init.php');

$errors = [];

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(404);
    exit();
}


$show_lot = "SELECT l.name_lot, l.start_price, l.img_path, 
       (SELECT MAX(b.final_price) FROM bet b WHERE b.lot_id = l.id) current_price, 
       l.bet_step, l.description_lot, c.title, c.title_id, l.date_end, l.users_id
                            FROM lot l
                                JOIN category c ON l.category_id = c.id
                            WHERE l.id = ?";
$stmt = db_get_prepare_stmt($mysqli, $show_lot, [$id]);
$stmt->execute();
$result = $stmt->get_result();
$lot = $result->fetch_assoc();

if (!$lot) {
    http_response_code(404);
    exit();
}

//Текущая цена лота
if ($lot['current_price']) {
    $min_bet = $lot['current_price'] + $lot['bet_step'];
} else {
    $min_bet = $lot['start_price'] + $lot['bet_step'];
}

//Вывод инфорации по ставкам
$bet_info = "SELECT b.users_id, lot_id, b.dt_add, final_price, u.users_name
              FROM bet b
                  JOIN users u ON b.users_id = u.id
              WHERE lot_id = ?
              ORDER BY b.dt_add DESC";
$stmt = db_get_prepare_stmt($mysqli, $bet_info, [$id]);
$stmt->execute();
$result = $stmt->get_result();
$bets_info = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    $bet = [
        'cost' => is_numeric($_POST['cost']) ? $_POST['cost'] + 0 : $_POST['cost'],
    ];

    if (empty($_POST['cost'])) {
        $errors['cost'] = "Заполните это поле";
    }

    if (!empty($_POST['cost']) & (!is_int($bet['cost']) || $bet['cost'] < $min_bet)) {
        $errors['cost'] = "Введите целое число, которое больше или равно минимальной ставки";
    }

    if (!$errors) {
        $sql = "INSERT INTO bet (users_id, lot_id, dt_add, final_price)
        VALUES (?, ?, NOW(), ?)";
        $stmt = db_get_prepare_stmt($mysqli, $sql, [$_SESSION['user']['id'], $id, $bet['cost']]);
        $stmt->execute();

        header("Location: lot.php?id=" . $id);
        exit();
    }
}

//HTML-код главной страницы
$lot_content = include_template(
    'lot_temp.php',
    [
        'lot_info' => $lot,
        'categories' => $all_categories,
        'bet_info' => $bets_info,
        'errors' => $errors,
        'min_bet' => $min_bet,
        'id' => $id
    ]
);

//HTML-код всей страницы
$layout_content = include_template(
    'layout.php',
    ['main_content' => $lot_content, 'title' => 'Интернет-аукцион «YetiCave»', 'categories' => $all_categories]
);

print($layout_content);
