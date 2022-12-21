<?php

namespace App\Core;

class Config
{

    public static  $config = [];

    public static function get($config)
    {
        $config = strtolower($config);

        static::$config[$config]  = require __DIR__ . "/../config/{$config}.php";

        return static::$config[$config];
    }
}
