<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

// $router = new  Router;
// $router->start($route);
// or, since call only one method

(new Router)
    ->start($_SERVER['REQUEST_URI']);
