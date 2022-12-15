<?php
require 'TopicData.php';

if (isset($_POST) && sizeof($_POST) > 0) {

    $data = new TopicData();
    $data->create($_POST);

    header("Location: /");
    exit;
}

$title = 'New Topic';

require './views/create.view.php';
