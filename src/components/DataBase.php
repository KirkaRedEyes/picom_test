<?php

class DataBase
{
    /* Подключение и проверка таблицы users */
    protected static function getConnection()
    {
        $dbConfig = require './config/db.php';
        ORM::configure($dbConfig);

        //todo Миграции
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
    }

    public static function selectUsers()
    {
        static::getConnection();

        return ORM::for_table('user')->find_array();
    }

    public static function truncateUserTable()
    {
        static::getConnection();

        ORM::get_db()->exec('TRUNCATE `user`');
    }

    public static function addUser($user)
    {
        static::getConnection();

        $addUser = ORM::for_table('user')->create();

        $addUser->first_name = $user['first_name'];
        $addUser->last_name = $user['last_name'];
        $addUser->phone = $user['phone'];
        $addUser->email = $user['email'];
        $addUser->location = $user['location'];
        $addUser->registered_at = $user['registered_at'];

        $addUser->save();
    }

    public static function deleteUser($user_id)
    {
        static::getConnection();

        ORM::for_table('user')->find_one($user_id)->delete();
    }
}