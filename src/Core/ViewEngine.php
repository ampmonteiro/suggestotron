<?php

namespace App\Core;

class ViewEngine
{
    protected $view = '';
    protected $layout = '';
    protected $data = [];
    protected $viewPath = '/../../views/';

    public function __construct($view)
    {
        $this->view = $this->viewPath . "{$view}.view.php";
    }

    public function render($data = [], $layout = '')
    {
        if (!empty($layout)) {
            $this->layout =  $this->viewPath . "/layouts/{$layout}.view.php";
        }

        if (!empty($data)) {
            $this->data = $data;
        }

        # https://www.phptutorial.net/php-tutorial/php-variable-variables/
        foreach ($this->data  as $key => $value) {
            $$key = $value;
        }

        // or with https://www.php.net/manual/en/function.extract.php
        # extract($data);

        if (empty($this->layout)) {
            require __DIR__ . $this->view;
            exit;
        }

        ob_start();
        require __DIR__ . $this->view;
        $viewContent = ob_get_clean();

        require __DIR__ .  $this->layout;
    }

    public function setLayout($layout)
    {
        $this->layout = $this->viewPath . "/layouts/{$layout}.view.php";

        return $this;
    }

    public function setData($values)
    {
        $this->data = $values;

        return $this;
    }

    # old way
    // public function render($page, $data = [])
    // {
    //     foreach ($data as $key => $value) {
    //         $this->{$key} = $value;
    //     }

    //     $this->page = "{$page}.view.php";

    //     require __DIR__ . '/../../views/layouts/' . $this->layout;
    // }

    // public function content()
    // {
    //     require __DIR__ . '/../../views/' . $this->page;
    // }
}
