<?php
if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

require ('init.php');
require ('helpers.php');

$page_content = include_template('login_temp.php', ['categories' => $all_categories]);

//HTML-код всей страницы
$default_layout = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Вход', 'categories' => $all_categories]);

if ($_SERVER ['REQUEST_METHOD'] !== 'POST') {
    print_r($default_layout);
    exit();
}

$required_items = ['email', 'password'];
$errors = [];

foreach ($required_items as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = "Заполните это поле";
    } 
}

//Проверка на наличие пользователя в базе
$guest = $mysqli->real_escape_string($_POST['email']);
$guest_uniq = $mysqli->query("SELECT * 
                                    FROM users
                                    WHERE email = '$guest'");

$user = $guest_uniq->fetch_array(MYSQLI_ASSOC);

if (!empty($_POST['email']) && !$user['email']) {
    $errors['email'] = "Такого пользователя не существует";
}

if (!empty($_POST['password']) && !password_verify($_POST['password'], $user['passwords'])) {
    $errors['password'] = "Введен неправильный пароль";
}

if (!$errors & $user) {
    $_SESSION['user'] = $user;

    header("Location: /index.php"); 
    exit();
}

$page_content = include_template('login_temp.php', ['errors' => $errors, 'categories' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Вход', 'categories' => $all_categories]);

print($layout_content);