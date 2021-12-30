/*Добавляем данные в таблицу Категории*/
INSERT INTO category
    (title, title_id)
VALUES
    ('Доска и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Ботинки', 'boots'),
    ('Одежда', 'clothing'),
    ('Инструменты', 'tools'),
    ('Разное', 'others');

/*Добавляем данные в таблицу Пользователи*/
INSERT INTO users
    (users_name, email, passwords, contacts, dt_add)
VALUES
    ('Эрен', 'boardseren@gmail.com', 'qwerty', '0678582503', NOW()),
    ('Хината', 'hinata13@gmail.com', 'asdfgh', '0679242501', NOW()),
    ('Джон', 'jhon@gmail.com', 'zxcvbn', '0678536703', NOW()),
    ('Байек', 'bayek@gmail.com', 'qazwsx', '0678123403', NOW());

/*Добавляем данные в таблицу Лот*/
INSERT INTO lot
    (users_id, winner_id, category_id, dt_add, name_lot, description_lot, img_path, start_price, date_end, bet_step)
VALUES
    ('1', '4', '1', NOW(), 'DC Ply Mens 2016/2017 Snowboard', 'Легкий маневренный сноуборд для фристайла.', 'img/lot-2.jpg', '15999', '2022-11-29', '1000'),
    ('3', '4', '2', NOW(), 'Крепления Union Contact Pro 2015 года размер L/XL', 'Удобные и прочные крепления для комфортной езды', 'img/lot-3.jpg', '8000', '2022-11-30', '200'),
    ('1', '2', '3', NOW(), 'Ботинки для сноуборда DC Mutiny Charocal', 'Комфортные и жесткие ботинки. В самый раз для новичков', 'img/lot-4.jpg', '10999', '2022-12-05', '500'),
    ('2', '3', '4', NOW(), 'Куртка для сноуборда DC Mutiny Charocal', 'Отлчиная куртка, мембрана - 10к, в самый раз для комфорной езды в горах', 'img/lot-5.jpg', '7500', '2022-12-31', '500'),
    ('4', '1', '6', NOW(), 'Маска Oakley Canopy', 'Незаменимый атрибут в сильный снегопад', 'img/lot-6.jpg', '5400', '2022-12-07', '100'),
    ('4', '1', '1', NOW(), '2014 Rossignol District Snowboard', 'Прекрасный сноуборд для тех, кто любит фрирайд', 'img/lot-1.jpg', '10999', '2022-12-28', '1000');
    
 /*Добавляем данные в таблицу Ставка*/
INSERT INTO bet
    (users_id, lot_id, dt_add, final_price)
VALUES
    ('2', '6', NOW(), '11499'),
    ('2', '3', NOW(), '11499'),
    ('1', '4', NOW(), '8000'),
    ('3', '1', NOW(), '16999'),
    ('4', '5', NOW(), '5500'),
    ('3', '1', NOW(), '17999'),
    ('1', '6', NOW(), '11999'),
    ('4', '3', NOW(), '11999'),
    ('2', '2', NOW(), '8200');

/*Выводим все категории */
SELECT * 
FROM category;

/*Выводим самые новые лоты */
SELECT l.name_lot, l.start_price, l.img_path, MAX(b.final_price), c.title 
FROM lot l
    INNER JOIN bet b ON l.id = b.lot_id
    INNER JOIN category c ON l.category_id = c.id
WHERE l.date_end > NOW()
GROUP BY b.lot_id;

/*Выводим лот по его ID */
SELECT l.id, l.name_lot, c.title
FROM lot L
    INNER JOIN category c ON l.category_id = c.id
WHERE l.id = 2;

/*Обновляем название лота по его идентификатору */
UPDATE lot
SET name_lot = 'New name'
WHERE id = 1;

/*Выводим список ставок для лота и сортируем по дате */
SELECT *
FROM bet
WHERE lot_id = 6
ORDER BY dt_add;