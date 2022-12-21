<?php

require './src/TopicData.php';

require './src/Core/helpers.php';

$topics = new \App\TopicData();

$result = $topics->getAllTopics();

$title = 'List of Topics';

// render(
//     'index',
//     compact('title', 'result'),
//     'base'
// );

view('index')
    ->render(
        compact('title', 'result'),
        'base'
    );
