<main class="p-10 py-4 my-3 mx-auto max-w-xs md:max-w-xl">
    <section class="flex justify-between">
        <h2 class="mb-6 text-3xl">
            <?= $title ?>:
        </h2>

        <form action="/vote" method="post">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <button class="py-3 px-5 rounded-md font-bold text-green-50 bg-green-500 hover:bg-green-700">
                Likes: <?= $data['count']  ?>
            </button>
        </form>

        <form action="/delete" method="post">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <button class="p-3 rounded-md font-bold text-gray-50 bg-rose-500 hover:bg-rose-700">
                Delete
            </button>
        </form>
    </section>

    <h3 class="mb-3 text-xl"><?= $data['title'] ?></h3>
    <?php partial('topic-form', compact('data', 'error', 'old')) ?>
</main>