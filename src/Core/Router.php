<?php

namespace App\Core;

use App\Controllers\Topics;

class Router
{
    public function start($currentURI)
    {
        $route = $this->getRoute($currentURI);

        $controller = new Topics();

        $method = [$controller, $route];

        if (!is_callable($method)) {
            die('Not FOUND');
        }

        return $method();
    }

    protected function getRoute($uri)
    {
        $route = explode('?', $uri)[0] ?? '';

        if (empty($route) || $route === '/') {
            $route = 'index';
        }

        return trim(str_replace('/', '', $route));
    }
}
