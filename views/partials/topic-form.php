<form method="POST" class="bg-amber-300 p-8 rounded-xl grid gap-5">

    <label class="flex flex-col gap-3 max-w-sm md:max-w-md">
        <span class="text-lg font-semibold">
            Title:
        </span>
        <input class="border-2 rounded-lg p-4 " type="text" name="title" value="<?= $old['title'] ?? $data['title'] ?? '' ?>">
    </label>

    <?php if (!empty($error['title'])) : ?>
        <p>
            <?= $error['title'] ?>
        </p>
    <?php endif; ?>

    <label class="flex flex-col gap-3 max-w-sm md:max-w-md">
        <span class="text-lg font-semibold">
            Description:
        </span>

        <textarea class="border-2 rounded-lg p-4" name="description" cols="50" rows="5"><?= $old['description'] ?? trim($data['description']) ?? '' ?></textarea>
    </label>

    <?php if (!empty($error['description'])) : ?>
        <p>
            <?= $error['description'] ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($data['id'])) : ?>

        <input type="hidden" name="id" value="<?= $data['id'] ?>">

    <?php endif ?>

    <button class="justify-self-end mt-8 bg-stone-700 hover:bg-stone-500 text-white text-lg font-bold rounded-xl p-5">
        Save
    </button>

</form>