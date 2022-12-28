<?php

namespace App\Core;

class Router
{
    public function start($route)
    {
        $path = realpath("./src/topics/{$route}.php");

        if (file_exists($path)) {
            require $path;
            exit;
        }

        die('Not FOUND');
    }
}
