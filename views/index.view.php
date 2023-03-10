<main class="my-10 grid md:grid-cols-2 lg:grid-cols-3 auto-rows-max gap-3 mx-auto max-w-5xl">
    <?php foreach ($result as $item) : ?>
        <article class="flex flex-col justify-between h-52 max-w-sm gap-3 pt-4 px-12 bg-amber-300 text-black drop-shadow-2xl">
            <h3>
                <?= h($item['title']) ?>
                (ID: <?= $item['id'] ?>)
            </h3>
            <p class="truncate">
                <?= h($item['description']) ?>
            </p>

            <p class="my-3 flex gap-5 items-center justify-between">
                <strong>
                    Likes: <?= $item['count'] ?? 0 ?>
                </strong>
                <a class="p-3 rounded-md font-bold text-gray-50 bg-stone-500 hover:bg-stone-700" href="/edit?id=<?= $item['id'] ?>">
                    Edit
                </a>
            </p>
        </article>
    <?php endforeach; ?>
</main>