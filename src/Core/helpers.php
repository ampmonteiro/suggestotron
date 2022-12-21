<?php

function h($val)
{
    return htmlspecialchars($val);
}

function render($view, $data = [], $layout = '')
{
    (new \App\Core\ViewEngine($view))
        ->render(
            $data,
            $layout
        );
}

function partial($name, $data = [])
{
    extract($data);

    require __DIR__ . '/../../views/partials/' . $name . '.php';
}


function view($currentView)
{
    return new \App\Core\ViewEngine($currentView);
}
