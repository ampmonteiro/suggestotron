<?php

namespace App\Core;

use App\Core\Config;

class Router
{
    protected  $configRoutes;
    protected  $params = [];

    public function __construct()
    {
        $this->configRoutes = Config::get('routes');
    }

    public function start($currentURI)
    {
        $route =  $this->getRoute($currentURI);

        $action = $this->getController($route);

        return $action($this->params);
    }

    // from original project
    // Only works on built in php server (not in apache or ngnix)
    // protected function getAction($route)
    // {
    //     try {
    //         foreach ($this->configRoutes['routes'] as $path => $defaults) {
    //             $regex = '@' . preg_replace(
    //                 '@:([\w]+)@',
    //                 '(?P<$1>[^/]+)',
    //                 str_replace(')', ')?', (string) $path)
    //             ) . '@';
    //             $matches = [];
    //             if (preg_match($regex, $route, $matches)) {

    //                 $options = $defaults;

    //                 foreach ($matches as $key => $value) {
    //                     if (is_numeric($key)) {
    //                         continue;
    //                     }

    //                     $options[$key] = $value;
    //                     if (isset($defaults[$key])) {
    //                         if (strpos($defaults[$key], ":$key") !== false) {
    //                             $options[$key] = str_replace(":$key", $value, $defaults[$key]);
    //                         }
    //                     }

    //                     if (isset($options['controller']) && isset($options['action'])) {
    //                         $ct = "\App\Controllers\\{$options['controller']}";

    //                         $selected = [new $ct, $options['action']];

    //                         if (is_callable($selected)) {
    //                             $this->options = $options;
    //                             return $selected;
    //                         } else {
    //                             die('fails');
    //                             $this->error($route);
    //                         }
    //                     } else {
    //                         $this->error($route);
    //                     }
    //                 }
    //             }
    //         }
    //     } catch (\Throwable $e) {
    //         $this->error($e);
    //     }
    // }

    protected function getRoute($uri)
    {
        $route = parse_url($uri);

        if (!empty($route['query'])) {
            $query_params = explode('&', $route['query']);
            $rs = [];
            foreach ($query_params as $value) {

                $tmp = explode('=', $value);

                $rs[$tmp[0]] = $tmp[1];
            }

            $this->params = $rs;
        }

        return  str_replace('/', '', $route['path']);
    }

    protected function getController($route)
    {
        if (!array_key_exists($route, $this->configRoutes)) {
            $this->error('404');
        }

        $controller_ar  = $this->configRoutes[$route];

        $action = [new $controller_ar[0], $controller_ar[1]];

        if (is_callable($action)) {
            return $action;
        }
    }

    protected function error($code)
    {
        if (!array_key_exists('error', $this->configRoutes)) {
            http_response_code(500);
            die('An unknown error occurred, please try again!');
        }

        $this->start("error?code={$code}");
        exit;
    }
}
