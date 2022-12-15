<form method="POST">
    <p>
        <label>
            Title: <input type="text" name="title" value="<?= $topic['title'] ?? '' ?>">
        </label>
    </p>

    <p>
        <label>
            Description:
            <br>
            <textarea name="description" cols="50" rows="20"><?= trim($topic['description'] ?? '') ?>
            </textarea>
        </label>
    </p>

    <?php if (!empty($topic['id'])) : ?>

        <input type="hidden" name="id" value="<?= $topic['id'] ?>">

    <?php endif ?>

    <button> Save</button>

</form>