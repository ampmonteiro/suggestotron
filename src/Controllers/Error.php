<?php

namespace App\Controllers;

class Error
{
    public function index($options = [])
    {
        $data = [
            'code' => 500,
            'msg' => 'An unknown error occurred. Try later.',
            'title' => 'Server Error !!!'
        ];

        if (sizeof($options) === 0) {
            http_response_code(500);

            render('errors/index', $data, 'base');
            exit;
        }

        http_response_code($options['code']);

        $data = [
            'code' => $options['code'],
            'msg' => 'Page not Found',
            'title' => 'Page Not Found !!!'
        ];

        render('errors/index', $data, 'base');
    }
}
