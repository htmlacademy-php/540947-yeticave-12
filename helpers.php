<?php
date_default_timezone_set("Europe/Kiev");
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

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


/** Функция показа округленной цены карточки со знаком рубля
 * @param float $price Проверяемая цена
 * @return string Итоговый цена со знаком рубля
*/
function costs_of_item(float $price): string
{
    ceil($price);
    if ($price > 1000) {
        $price = number_format($price, 0, '', ' ');
    };
    return $price . ' ' . '₽';
} 

/** Функция подсчета оставшегося время до даты из будущего(финальной даты конца лота)
 * @param $time_end Финальная дата конца лота
 * @return array Выводит массив значений часов и минут до конца лота
 */
function diff_in_time($time_end)
{
    $time_end = strtotime($time_end);
    $final_time = $time_end - time();
//Расчет часов и минут до конца ставки
    $hours = str_pad(floor($final_time / 3600), 2, 0, STR_PAD_LEFT);
    $minutes = str_pad(floor(($final_time % 3600) / 60), 2, 0, STR_PAD_LEFT);
    return [$hours, $minutes];
}

/** Функция для сохранения введёных значений в полях формы
 * @param $name имя поля отправляемой формы 
 */
function getPostVal($name) {
    return $_POST[$name] ?? '';
}

/** Проверяет выбрана ли категория лота из списка.
 * @param $value
 * @param $cats_ids
 * @return void
 */
function validateCategoryId($value, $cats_ids)
{
    if (!in_array($value, $cats_ids)) {
        return "Выберите категорию из списка";
    }
}

/** Фукнция проверки стартовой цены. Стартовая цена не должна быть равна нулю
 * @param float $start_price Ввод начальной цены
 * @return void
 */
function validateStartPrice($start_price) {
    if ($start_price <= 0 || is_string($start_price)) {
        return "Сумма должна быть больше 0";
    }
}

/** Фукнция проверки цены ставки. Цена ставки не должна быть равна нулю и должна быть целым числом
 * @param  int $step_p Ввод начальной цены
 * @return void
 */
function validateStep($step_p) {
    if ($step_p <= 0 || !is_int($step_p) || is_string($step_p)) {
        return "Сумма ставки должна быть целым числом и больше 0";
    }
}

/** Функция проверки финальной даты лота. Дата лота должна быть больше текущей даты хотя бы на один день.
 * @param date Ввод финальной даты окончания лота
 * @return void
 */
function validateDate($date) {
    if (is_date_valid($date) && diff_in_time($date)[0] < "24") {
        return "Финальная дата лота должна быть больше текущей даты хотя бы на 1 день";
    }
}

/** Функция проверки корректности ввода Email.
 * @param string $name Email вводимый пользователем
 * @return void
 */
function validateEmail($name) {
    if (!filter_var($name, FILTER_VALIDATE_EMAIL)){
        return "Введите корректный Email адресс";
    }
}

/** Функция проверки длинны ввода данных в поле формы.
 * @param string $name 
 * @return void
 */
function validateLength($name, $min, $max) {
    $len = strlen($name);
    if ($len < $min || $len > $max){
        return "Значение должно быть от $min до $max символов";
    }
}

/** Валидация формы
 * @param $form Данные из формы
 * @param $rules Правила валидации формы
 * @param $required Обязательные для заполнения поля
 * @return array
 */
function form_validation($form, $rules, $required)
{
    $errors = [];
    foreach ($form as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $validationResult = $rule($value);
            $errors[$key] = $validationResult;
            }
        if (in_array($key, $required) && empty($value)) {
            $errors[$key] = "Заполните это поле";
        } 
        }

    return $errors;
}

function bet_time($times)
{
    $users_time = strtotime($times);
    $time_bet = time() - $users_time;

    if ($time_bet >= 3600 && $time_bet < 3600 * 24) {
        $hours = floor($time_bet / 3600);
        $plural = get_noun_plural_form($hours, 'час', 'часа', 'часов');
        return $hours . ' ' . $plural . ' назад';
    }
    elseif ($time_bet >= 60 && $time_bet < 3600) {
        $minutes = floor(($time_bet % 3600) / 60);
        $plural = get_noun_plural_form($minutes, 'минута', 'минуты', 'минут');
        return $minutes . ' ' . $plural . ' назад';
    }
    elseif ($time_bet < 60) {
        $plural = get_noun_plural_form($time_bet, 'секунда', 'секунды', 'секунд');
        return $time_bet . ' ' . $plural . ' назад';
    }

    return date('d.m.y в H:i', $users_time);
}