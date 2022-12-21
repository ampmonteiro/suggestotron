<?php

require __DIR__ . '/vendor/autoload.php';

if (isset($_POST) && sizeof($_POST) > 0) {

    $data = new \App\TopicData();
    $data->create($_POST);

    header("Location: /");
    exit;
}

$title = 'New Topic';

render(
    'create',
    compact('title'),
    'base'
);
