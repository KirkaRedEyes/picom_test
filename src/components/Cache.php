<?php

class Cache
{
    /** @var string путь к файлам кеша */
    private static $_path ='runtime/cache';

    /** Создаем файл */
    public static function set($key, $value)
    {
        $path = static::$_path . '/' . $key;

        if (!is_dir(static::$_path))
            mkdir(static::$_path, 0777, true);

        file_put_contents($path, json_encode($value));
    }

    /**
     * Получаем файл с кешем
     *
     * @param string $key путь с файлом
     *
     * @return array|null.
     */
    public static function get($key)
    {
        $path = static::$_path . '/' . $key;

        if (is_file($path)) {
            $data = file_get_contents($path);
            return json_decode($data, true);
        }

        return null;
    }

    /**
     * Узнаем существует ли файл
     *
     * @param string $key путь с файлом
     *
     * @return boolean.
     */
    public static function has($key)
    {
        $path = static::$_path . '/' . $key;

        return is_file($path);
    }

    /** Удаление файла */
    public static function reset($key)
    {
        $path = static::$_path . '/' . $key;

        if (is_file($path)) {
            unlink($path);
        }
    }
}