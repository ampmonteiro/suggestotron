<?php
require 'TopicData.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

    $data = new TopicData();
    if ($data->update($_POST)) {
        header("Location: /index.php");
        exit;
    }

    die("An error occurred");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("You did not pass in an ID.");
}

$data = new TopicData();
$topic = $data->getTopic($_GET['id']);

// if not found returns false
if (!$topic) {
    die("Topic not found!");
}

?>

<h2>Edit Topic</h2>
<form action="edit.php" method="POST">
    <p>
        <label>
            Title: <input type="text" name="title" value="<?= $topic['title'] ?>">
        </label>
    </p>

    <p>
        <label>
            Description:
            <br>
            <textarea name="description" cols="50" rows="20"><?= trim($topic['description']) ?>
            </textarea>
        </label>
    </p>

    <input type="hidden" name="id" value="<?= $topic['id']; ?>">

    <button> Edit Topic </button>

</form>