CREATE DATABASE yeticave13
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave13

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(64) NOT NULL UNIQUE,
    name_category VARCHAR(32) NOT NULL
);


CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    winner_id INT NOT NULL,
    category_id INT NOT NULL, 
    dt_add DATETIME(0),
    name_lot VARCHAR(64) NOT NULL,
    description_lot TEXT,
    img_path VARCHAR(255),
    start_price INT NOT NULL,
    date_end DATETIME(0) NOT NULL,
    bet_step INT
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    lot_id INT NOT NULL,
    dt_add DATETIME(0),
    final_price INT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lot_id INT NOT NULL,
    bet_id INT NOT NULL,
    users_name VARCHAR(64)  NOT NULL UNIQUE,
    email VARCHAR(128) NOT NULL UNIQUE,
    passwords VARCHAR(64) NOT NULL UNIQUE,
    contacts TEXT,
    dt_add DATETIME(0)
);


