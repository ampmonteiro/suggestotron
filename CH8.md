# Chapter 8 - Styling Suggestron

## Goals

- Make our application look visually appealing
- using `tailwind css` via cdn

## Steps

- Step 1

  Let change our `header.php` partial to:

  ```html
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
      />
      <title><?= $title ?></title>
      <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body
      class="h-screen bg-gray-100 grid grid-rows-[60px_auto_50px]"
    >
      <header
        class="py-2 bg-sky-900 flex items-center justify-around"
      >
        <h1 class="font-bold text-xl text-white">
          <a href="/"> Suggestron </a>
        </h1>
        <p class="text-white">
          <a
            class="p-3 rounded-md font-bold text-gray-50 bg-blue-600 hover:bg-blue-800"
            href="/create.php"
            >Create</a
          >
        </p>
      </header>
    </body>
  </html>
  ```

  here is added tailwind css framework via cdn.

  Applied some css classes to body, allow content be center and footer stay on bottom.

  Added name of the projected, that is link that allowed go back to index / home page
  And styled the create button.

- Step2:

  Let change the `footer.php` partial to this:

  ```html
  <footer class="bg-black py-1 flex justify-center items-center text-white max-h-min">
      <p>
          &copy; 2022 by
          <a class="hover:text-blue-300" href="https://github.com/ampmonteiro" title="visit my github">
              AMPM
          </a>
      </p>
  </footer>
  </body>

  </html>
  ```

  Note: feel free to change the copyright

- Step 3:

  the first page to be change is `index.php` (home page) to this:

  ```html
  <?php include './views/partials/header.php' ?>
  <main
    class="my-10 grid md:grid-cols-2 lg:grid-cols-3 auto-rows-max gap-3 mx-auto max-w-5xl"
  >
    <?php foreach ($result as $item) : ?>
    <article
      class="flex flex-col justify-between h-52 max-w-sm gap-3 pt-4 px-12 bg-amber-300 text-black drop-shadow-2xl"
    >
      <h3>
        <?= h($item['title']) ?>
        (ID:
        <?= $item['id'] ?>)
      </h3>
      <p>
        <?= h($item['description']) ?>
      </p>

      <p class="self-end flex gap-5 my-3 ">
        <a
          class="p-3 rounded-md font-bold text-gray-50 bg-stone-500 hover:bg-stone-700  "
          href="/edit.php/?id=<?= $item['id'] ?>"
        >
          Edit</a
        >
        <a
          class="p-3 rounded-md font-bold text-gray-50 bg-rose-500 hover:bg-rose-700 "
          href="/delete.php/?id=<?= $item['id'] ?>"
        >
          Delete</a
        >
      </p>
    </article>

    <?php endforeach; ?>
  </main>
  <?php include './views/partials/footer.php' ?>
  ```

  In mobile will be stacked.

  In tablet just two cols and more than that 3 cols.

  which will be something like this:

  ![Index](/styled_index.png 'index styled')

- Step 4:

  Next the create and edit, which will be the same;

  ```html
  <?php include './views/partials/header.php'  ?>

  <main class="p-10 py-4 my-3 mx-auto max-w-xs md:max-w-xl">
    <h2 class="mb-6 text-3xl"><?= $title ?></h2>

    <?php require './views/partials/topic-form.php' ?>
  </main>

  <?php include './views/partials/footer.php'  ?>
  ```

- Step 5:

  For last the `topic-form.php` partial:

  ```php
    <form method="POST" class="bg-amber-300 p-8 rounded-xl grid gap-5">

        <label class="flex flex-col gap-3 max-w-sm md:max-w-md">
            <span class="text-lg font-semibold">
                Title:
            </span>
            <input class="border-2 rounded-lg p-4 " type="text" name="title" value="<?= $topic['title'] ?? '' ?>">
        </label>

        <label class="flex flex-col gap-3 max-w-sm md:max-w-md">
            <span class="text-lg font-semibold">
                Description:
            </span>

            <textarea class="border-2 rounded-lg p-4" name="description" cols="50" rows="5"><?= trim($topic['description'] ?? '') ?></textarea>
        </label>

        <?php if (!empty($topic['id'])) : ?>

            <input type="hidden" name="id" value="<?= $topic['id'] ?>">

        <?php endif ?>

        <button class="justify-self-end mt-8 bg-stone-700 hover:bg-stone-500 text-white text-lg font-bold rounded-xl p-5"> Save</button>
    </form>
  ```

  And will be something like:

  ![form](/create-edit-form.png 'form styled')

## Explanation

So in this chapter we just made our website better visually by using `tailwind css` framework.

Of course we could use `bootstrap css` but we would not take the vantages things like `css grid` feature.
