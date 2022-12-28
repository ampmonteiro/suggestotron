<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

$route = explode('?', $_SERVER['REQUEST_URI'])[0] ?? '';

if (empty($route) || $route === '/') {
    $route = 'index';
}

$route = trim(str_replace('/', '', $route));

// $router = new  Router;
// $router->start($route);
// or, since call only one method

(new Router)->start($route);
