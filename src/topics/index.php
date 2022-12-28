<?php

$topics = new \App\TopicData();

$result = $topics->getAllTopics();

$title = 'List of Topics';

view('index')
    ->render(
        compact('title', 'result'),
        'base'
    );
