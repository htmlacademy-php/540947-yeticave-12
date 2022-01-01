CREATE DATABASE yeticave13
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave13;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    title_id VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_name VARCHAR(255)  NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    passwords VARCHAR(255) NOT NULL,
    contacts TEXT,
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT UNSIGNED,
    winner_id INT UNSIGNED,
    category_id INT UNSIGNED, 
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    name_lot VARCHAR(255) NOT NULL,
    description_lot TEXT,
    img_path VARCHAR(255),
    start_price INT NOT NULL,
    date_end DATETIME(0) NOT NULL,
    bet_step INT,
    FOREIGN KEY (users_id) REFERENCES users(id) on update cascade on delete cascade,
    FOREIGN KEY (winner_id) REFERENCES users(id) on update cascade on delete cascade,
    FOREIGN KEY (category_id) REFERENCES category(id) on update cascade on delete cascade
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT UNSIGNED,
    lot_id INT UNSIGNED,
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    final_price DECIMAL,
    FOREIGN KEY (users_id) REFERENCES users(id) on update cascade on delete cascade,
    FOREIGN KEY (lot_id) REFERENCES lot(id) on update cascade on delete cascade
);

//Добавили полям полнотекстовый индекс для возможности выполнения поиска
CREATE FULLTEXT INDEX lot_search ON lot(name_lot, description_lot);