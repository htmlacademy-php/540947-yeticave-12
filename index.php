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
        'end_time' => '2021-10-22',
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'img_url' => 'img/lot-2.jpg',
        'end_time' => '2021-11-22',
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'img_url' => 'img/lot-3.jpg',
        'end_time' => '2021-12-13',
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'img_url' => 'img/lot-4.jpg',
        'end_time' => '2021-10-29',
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'img_url' => 'img/lot-5.jpg',
        'end_time' => '2021-12-01',
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'img_url' => 'img/lot-6.jpg',
        'end_time' => '2021-12-31',
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

date_default_timezone_set("Europe/Moscow");
//Функция подсчета оставшегося время до даты из будущего
function diff_in_time($time_end)
{
    $time_end = strtotime($time_end);
    $final_time = $time_end - time();
//Расчет часов и минут до конца ставки
    $hours = floor($final_time / 3600);
    $minutes = floor(($final_time % 3600) / 60);
    $minutes = str_pad($minutes, 2, 0, STR_PAD_LEFT);
    return [$hours, $minutes];
};

require_once('helpers.php');

//HTML-код главной страницы
$page_content = include_template('main.php', ['categories' => $categories, 'advertisement' => $advertisement]);

//HTML-код всей страницы
$layout_content = include_template('layout.php', ['main_content' => $page_content, 'title' => 'Интернет-аукцион «YetiCave»', 'user_name' => 'Богдан', 'categories' => $categories, 'is_auth' => $is_auth]);

print($layout_content);


