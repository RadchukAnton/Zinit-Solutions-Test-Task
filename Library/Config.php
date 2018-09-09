<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 08.09.18
 * Time: 12:18
 */

namespace Library;


class Config
{
    private static $items = [];

    public static function get($key)
    {
        if(isset(self::$items[$key])){
            return self::$items[$key];
        }

        return null;
    }

    public static function set($key, $value)
    {
        self::$items[$key] = $value;
    }
}