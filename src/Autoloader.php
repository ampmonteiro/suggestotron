<?php

namespace App;

class Autoloader
{
    public function load($className)
    {
        $file = __DIR__  . "/" . str_replace("\\", "/", $className) . '.php';

        $file = str_replace('App/', '', $file);

        if (file_exists($file)) {
            require $file;
        } else {
            return false;
        }
    }

    public function register()
    {
        spl_autoload_register([$this, 'load']);
    }
}

$loader = new Autoloader();
$loader->register();
