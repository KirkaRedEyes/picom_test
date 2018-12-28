<?php

class DataBase
{
    /* Подключение и проверка таблицы users */
    protected static function getConnection()
    {
        $dbConfig = require './config/db.php';
        ORM::configure($dbConfig);
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