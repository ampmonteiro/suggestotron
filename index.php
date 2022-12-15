<?php

require 'TopicData.php';

$topics = new TopicData();

$result = $topics->getAllTopics();

function h($val)
{
    return htmlspecialchars($val);
}

$title = 'List of Topics';

require './views/index.view.php';
