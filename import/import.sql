CREATE DATABASE IF NOT EXISTS `Plane Spotter Storage`;

USE `Plane Spotter Storage`;

CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    pass VARCHAR(100),
    token VARCHAR(300),
    uploads INT DEFAULT 0,
    sudo BOOLEAN
);
CREATE TABLE `data` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image_id VARCHAR(200),
    name VARCHAR(100),
    name_plane VARCHAR(100),
    title_textarea_1 VARCHAR(100),
    textarea_1 VARCHAR(800),
    title_textarea_2 VARCHAR(100),
    textarea_2 VARCHAR(800),
    title_textarea_3 VARCHAR(100),
    textarea_3 VARCHAR(800),    
    title_textarea_4 VARCHAR(100),
    textarea_4 VARCHAR(800),
    entry_date datetime default CURRENT_TIMESTAMP,
    views  INT DEFAULT 0
    like  INT DEFAULT 0
    dislike  INT DEFAULT 0
);

CREATE TABLE `likes` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image_id VARCHAR(200),
    liked BOOLEAN,
    disliked BOOLEAN,
    UNIQUE KEY unique_like (user_id, image_id)
);

CREATE TABLE `commands` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    image_id VARCHAR(200),
    textarea VARCHAR(800)
);

CREATE TABLE `testers` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    tester_token VARCHAR(200),
);