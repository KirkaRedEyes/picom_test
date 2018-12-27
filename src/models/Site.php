<?php

require 'components/Cache.php';
require 'components/DataBase.php';

use Katzgrau\KLogger\Logger;

class Site
{
    /** @var string путь к логам */
    private static $_pathLog = 'runtime/logs';

    /** @var string путь к пользователям в файле */
    private static $_pathUsers = 'data/users';

    /**
     * Получение данных из базы данных
     *
     * @return array.
     */
    public function loadFromDB()
    {
        $log = new Logger(static::$_pathLog);
        $users = Cache::get('db');

        if (!isset($users)) {
            $users = DataBase::selectUsers();

            if (is_array($users)) {
                foreach ($users as $k => $user) {
                    $users[$k]['location'] = json_decode($user['location'], 1);
                }
            }

            Cache::set('db', $users);
            $log->info('Load from db');
        } else {
            $log->info('Load from cache');
        }

        if (empty($users)) $users = [];

        return $users;
    }

    /**
     * Заполнение таблицы users
     *
     * @return boolean.
     */
    public function generateDB()
    {
        $log = new Logger(static::$_pathLog);

        DataBase::truncateUserTable();

        $users = []; // Для логов
        $getUsers = json_decode(file_get_contents('https://randomuser.me/api/?results=5&nat=gb'), true);
        foreach ($getUsers['results'] as $data) {
            $location = json_encode([
                'street' => $data['location']['street'],
                'city' => $data['location']['city'],
                'state' => $data['location']['state'],
                'postcode' => $data['location']['postcode'],
            ]);

            $user = [
                'first_name' => $data['name']['first'],
                'last_name' => $data['name']['last'],
                'location' => $location,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registered_at' => strtotime($data['registered']['date']),
            ];

            DataBase::addUser($user);
            $users[] = $user;
        }

        $log->debug('Fills db', $users);
        Cache::reset('db');

        return true;
    }

    /**
     * Удаление user по id из базы данных
     *
     * @return boolean.
     */
    public function removeFromDB()
    {
        $id = $_GET['id'];

        $log = new Logger(static::$_pathLog);

        DataBase::deleteUser($id);

        Cache::reset('db');
        $log->info('Remove from db ' . $id);

        return true;
    }

    /**
     * Получение данных из файла user
     *
     * @return array.
     */
    public function loadFromFile()
    {
        $log = new Logger(static::$_pathLog);

        if (file_exists(static::$_pathUsers))
            $users = json_decode(file_get_contents(static::$_pathUsers), 1);

        if (empty($users)) $users = [];

        $log->info('Load from file');

        return $users;
    }

    /**
     * Заполнение файла user
     *
     * @return boolean.
     */
    public function generateFile()
    {
        $log = new Logger(static::$_pathLog);

        $users = [];
        $getUsers = json_decode(file_get_contents('https://randomuser.me/api/?results=5&nat=gb'), true)['results'];
        foreach ($getUsers as $data) {
            $uuid = uniqid();
            $location = [
                'street' => $data['location']['street'],
                'city' => $data['location']['city'],
                'state' => $data['location']['state'],
                'postcode' => $data['location']['postcode'],
            ];

            $users[$uuid] = [
                'id' => $uuid,
                'first_name' => $data['name']['first'],
                'last_name' => $data['name']['last'],
                'location' => $location,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registered_at' => strtotime($data['registered']['date']),
            ];
        }

        if (!is_dir(dirname(static::$_pathUsers)))
            mkdir(dirname(static::$_pathUsers), 0777, true);

        file_put_contents(static::$_pathUsers, json_encode($users));

        $log->debug('Fills files', $users);

        return true;
    }

    /**
     * Удаление user по id из файла
     *
     * @return boolean.
     */
    public function removeFromFile()
    {
        $log = new Logger(static::$_pathLog);

        $id = $_GET['id'];
        $users = json_decode(file_get_contents(static::$_pathUsers), 1);
        unset($users[$id]);
        file_put_contents(static::$_pathUsers, json_encode($users));

        $log->info('Remove from file ' . $id);

        return true;
    }
}