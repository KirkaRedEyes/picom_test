<?php
/* Скрипт для создания таблиц */

require 'vendor/autoload.php';

$dbConfig = require './config/db.php';
ORM::configure($dbConfig);

ORM::raw_execute('CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(255) NOT NULL ,
    `last_name` VARCHAR(255) NOT NULL ,
    `phone` VARCHAR(255) NOT NULL ,
    `email` VARCHAR(255) NOT NULL ,
    `location` TEXT NOT NULL ,
    `registered_at` INT NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;');


