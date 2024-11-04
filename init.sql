CREATE DATABASE IF NOT EXISTS todolist;

USE todolist;

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NOT NULL DEFAULT 'assets/img/default-avatar.png',
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS task_board (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    section_num INT NOT NULL DEFAULT '0',
    task_num INT NOT NULL DEFAULT '0',
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS task_section (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    sort_index INT NOT NULL DEFAULT '0',
    task_board_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (task_board_id) REFERENCES task_board(id)
);

CREATE TABLE IF NOT EXISTS task (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    complete_date DATE DEFAULT NULL,
    task_section_id INT NOT NULL,
    task_board_id INT NOT NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT '0',
    sort_index INT NOT NULL DEFAULT '0',
    PRIMARY KEY (id),
    FOREIGN KEY (task_section_id) REFERENCES task_section(id),
    FOREIGN KEY (task_board_id) REFERENCES task_board(id)
);
