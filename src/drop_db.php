<?php
/* Скрипт для удаления таблиц */

require 'vendor/autoload.php';

$dbConfig = require './config/db.php';
ORM::configure($dbConfig);

ORM::raw_execute('DROP TABLE `user`');


