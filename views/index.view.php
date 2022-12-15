<?php include './views/partials/header.php' ?>

<p><a href="/create.php">Create</a></p>

<?php foreach ($result as $item) : ?>
    <h3>
        <?= h($item['title']) ?>
        (ID: <?= $item['id'] ?>)
    </h3>
    <p>
        <?= h($item['description']) ?>
    </p>

    <p>
        <a href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a> ||
        <a href="/delete.php/?id=<?= $item['id'] ?>"> Delete</a>
    </p>

<?php endforeach; ?>

<?php include './views/partials/footer.php' ?>