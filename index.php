<?php
$is_auth = rand(0, 1);

$user_name = 'Богдан'; // укажите здесь ваше имя
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$advertisement = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'img_url' => 'img/lot-1.jpg',
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'img_url' => 'img/lot-2.jpg',
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'img_url' => 'img/lot-3.jpg',
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'img_url' => 'img/lot-4.jpg',
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'img_url' => 'img/lot-5.jpg',
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'img_url' => 'img/lot-6.jpg',
    ]
];

// Функция показа цены карточки
function costs_of_item(float $price): string
{
    ceil($price);
    if ($price > 1000) {
        $price = number_format($price, 0, '', ' ');
    };
    return $price . ' ' . '₽';
};

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

//HTML-код главной страницы
$page_content = include_template('main.php', ['categories' => $categories, 'advertisement' => $advertisement]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Интернет-аукцион «YetiCave»', 'user_name' => 'Богдан', 'categories' => $categories, 'is_auth' => $is_auth]);

print($layout_content);

?>

