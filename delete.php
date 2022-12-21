<?php
require './src/TopicData.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("You did not pass in an ID.");
}

$data = new \App\TopicData();
$topic = $data->getTopic($id);

// if not found returns false
if (!$topic) {
    die("Topic not found!");
}

if ($data->delete($topic['id'])) {
    header("Location: /index.php");
    exit;
}

die("An error occurred");
