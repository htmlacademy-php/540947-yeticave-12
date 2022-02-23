<?php

require('init.php');
require('helpers.php');

$page_content = include_template('sign_up_temp.php', ['categories' => $all_categories]);

//HTML-код всей страницы
$default_layout = include_template(
    'layout.php',
    ['main_content' => $page_content, 'title' => 'Регистрация', 'categories' => $all_categories]
);

if ($_SERVER ['REQUEST_METHOD'] !== 'POST') {
    print_r($default_layout);
    exit();
}

$required_items = ['email', 'password', 'name', 'message'];
$errors = [];

$rules = [
    'email' => function ($value) {
        return validateEmail($value);
    },
    'password' => function ($value) {
        return validateLength($value, 6, 15);
    },
    'name' => function ($value) {
        return validateLength($value, 4, 20);
    },
    'message' => function ($value) {
        return validateLength($value, 10, 500);
    },
];

// Валидация формы и проверка на заполняемость по обязательным полям
$errors = form_validation($_POST, $rules, $required_items);

//Отфильтровываем массив с ошибками, удаляя пустые значения
$errors = array_filter($errors);

//Проверка на уникальность Email
$email_guest = $mysqli->real_escape_string($_POST['email']);
$email_uniq = $mysqli->query(
    "SELECT email 
                                    FROM users
                                    WHERE email = '$email_guest'"
);

if ($email_uniq->num_rows > 0) {
    $errors['email'] = "Данный Emeil уже существует";
}

if (!$errors) {
    $sql = "INSERT INTO users (users_name, email, passwords, contacts)
        VALUES (?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt(
        $mysqli,
        $sql,
        [$_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['message']]
    );
    $stmt->execute();

    header("Location: /login.php");
    exit();
}

$page_content = include_template('sign_up_temp.php', ['errors' => $errors, 'categories' => $all_categories]);

//HTML-код всей страницы
$layout_content = include_template(
    'layout.php',
    ['main_content' => $page_content, 'title' => 'Регистрация', 'categories' => $all_categories]
);

print($layout_content);
