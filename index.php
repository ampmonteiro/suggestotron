<?php

require 'TopicData.php';

$topics = new TopicData();

$result = $topics->getAllTopics();

function h($val)
{
    return htmlspecialchars($val);
}

?>

<?php foreach ($result as $item) : ?>
    <h3>
        <?= h($item['title']) ?>
        (ID: <?= $item['id'] ?>)
    </h3>
    <p>
        <?= h($item['description']) ?>
    </p>

    <p>
        <a href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a>
    </p>

<?php endforeach; ?>