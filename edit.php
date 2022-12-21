<?php

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

    $data = new \App\TopicData();
    if ($data->update($_POST)) {
        header("Location: /");
        exit;
    }

    die("An error occurred");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("You did not pass in an ID.");
}

$data = new \App\TopicData();
$topic = $data->getTopic($_GET['id']);

// if not found returns false
if (!$topic) {
    die("Topic not found!");
}

$title = "Edit Topic - {$topic['title']}";

render(
    'edit',
    compact('title', 'topic'),
    'base'
);
