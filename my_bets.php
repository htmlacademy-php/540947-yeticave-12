<?php
require ('init.php');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$u_id = $_SESSION['user']['id'];

$sql = "SELECT DISTINCT l.name_lot, l.img_path, l.id, l.winner_id, l.date_end, c.title, b.dt_add, b.final_price, u.contacts
        FROM lot l
            JOIN category c ON l.category_id = c.id 
            JOIN users u ON l.users_id = u.id
            JOIN bet b ON l.id = b.lot_id
        WHERE b.users_id = ?
        ORDER BY b.dt_add DESC";

$stmt = db_get_prepare_stmt($mysqli, $sql, [$u_id]);
$stmt->execute();
$result = $stmt->get_result();
$my_bet_info = $result->fetch_all(MYSQLI_ASSOC);

//HTML-код главной страницы
$bet_content = include_template('my_bets_temp.php', ['my_bet_info' => $my_bet_info, 'categories' => $all_categories, 'id' => $u_id]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $bet_content, 'title' => 'Мои ставки', 'categories' => $all_categories]);

print($layout_content);