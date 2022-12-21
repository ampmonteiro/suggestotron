# Chapter 7 - Separate PHP logic from visual part ( view / template )

## Goals

- better coding organization between logic and visual parts (HTML)
- Separate visual parts into separate file (view)
- Separate repetion visual parts into partials
- improve forms

## Steps

- Step 1

  You should make the distinction between business logic from visual part for better code organization and readability.

  So first create `views` folder into root of the project.

- Step 2

  The first file that will be changed, it is `index.php` file where you will cut the following code, which is view / view part only:

  ```php
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
  ```

  Then inside of views folder create a file with following name: `index.view.php` and paste the cuted code.

  So, now if you try to run `index.php` file by pointing the browser to `localhost`, you will see a blank page, so will fix this next.

- Step 3

  To dispaly the list of topics again, it is needed to load the view by using required in index.php
  so index.php would be as:

  ```php

      <?php

          require 'TopicData.php';

          $topics = new TopicData();

          $result = $topics->getAllTopics();

          function h($val)
          {
              return htmlspecialchars($val);
          }

          require './views/index.view.php';
  ```

  Once again, you can check this out in your browser, by refreshing the page or going to `localhost`.

  So our `index.php` is clean and small and in `index.view.php` is only the part related to HTML or that will be processed into HTML (the View).

- step 4:

  Next step is to change the `create.php` file to:

  ```php

      <?php
        require 'TopicData.php';

        if (isset($_POST) && sizeof($_POST) > 0) {

            $data = new TopicData();
            $data->create($_POST);

            header("Location: /");
            exit;
        }

        require './views/create.view.php';

  ```

  All html related like the form was removed and pasted into the view file that will be created next.

- step 5:

  Create a file in `views` folder called `create.view.php` and copy:

  ```html
  <h2>New Topic</h2>

  <form method="POST">
    <p>
      <label> Title: <input type="text" name="title" /> </label>
    </p>

    <p>
      <label>
        Description:
        <br />
        <textarea name="description" cols="50" rows="20"></textarea>
      </label>
    </p>

    <button>Add Topic</button>
  </form>
  ```

  if you notice a small change in form, the action attribute was
  removed because in case of the form is submited to same file / url,
  then no action attribute is needed.

- Step 6:

  Next file is `edit.php`, modified to:

  ```php

      <?php
        require 'TopicData.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

            $data = new TopicData();
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

        $data = new TopicData();
        $topic = $data->getTopic($_GET['id']);

        // if not found returns false
        if (!$topic) {
            die("Topic not found!");
        }

        require './views/edit.view.php';
  ```

  And so no need for `?>` close tag because since this file only php code, the same `for index.php` and `create.php files`

- Step 7

  Next, similar to create form, create a file in `views` folder, called `edit.view.php` and copy:

  ```php
      <h2>Edit Topic</h2>

      <form method="POST">
        <p>
          <label>
            Title:
            <input
              type="text"
              name="title"
              value="<?= $topic['title'] ?>"
            />
          </label>
        </p>

        <p>
          <label>
            Description:
            <br />
            <textarea name="description" cols="50" rows="20"><?= trim($topic['description']) ?></textarea
            >
          </label>
        </p>

        <input type="hidden" name="id" value="<?= $topic['id']; ?>" />

        <button>Edit Topic</button>
      </form>
  ```

  So if you test all pages, should be worked as previous. Delete page is no need to modify because dont contains any html related code.

  One thing that you should be notice is that create and edit are very similar. Can we avoid the repetion? That you see in next step.

- step 8

  To avoid this kind of repetion we can copy the repetead code into separated file, similar that we did to views, this is call `partials`, parts that are reusable view code into differents views.

  So for that create a new folder inside of `views`, called `partials`.

- step 9:

  Inside of `partials` folder, created `topic-form.php` and copy:

  ```php

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

          <button>Save</button>

      </form>

  ```

  Here exist a form, also without action attribute, where the title value verify already exist title, in case of editing show it.
  The same for description value. The input hidden is only render in case of editing a topic.
  The button have a generic name of save to avoid verification if is editing or new.

- Step 10

  To use this form, the `create.view.php` form should only contain:

  ```php

    <h2>New Topic</h2>

    <?php require './views/partials/topic-form.php' ?>

  ```

  and `edit.view.php`:

  ```php

    <h2>Edit Topic</h2>

    <?php require './views/partials/topic-form.php' ?>

  ```

  If you try edit a topic and do right click on the page, selection `view page source`, the hidden input with id of the topic should show. In case of new should not be visible in the html.

  Other scenarios for partials are, for example, in current pages are not well formed pages because dont have tags like html, head and body.
  So let do it next.

- Step 11:

  Before adding the right struture of html page, since every page will have html, head and body,
  should be created two partials to avoid same repetion.

  `header.php`, inside `views > partials`:

  ```php

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
    </head>

    <body>

  ```

  and `footer.php`:

  ```html

      </body>

    </html>
  ```

  So more two partials was created, next let load it.

- Step 11:

  To load this partials, first we will change `index.view.php` to:

  ```php

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

  ```

  Note that a button with create text was added

  In `created.view.php` to:

  ```php

    <?php include './views/partials/header.php'  ?>

    <h2><?= $title ?></h2>

    <?php require './views/partials/topic-form.php' ?>

    <?php include './views/partials/footer.php'  ?>

  ```

  The `edit.view.php` is the same as create.view.php.

  If you run the pages you will find an error because of `$title`, so let fix this next.

- Step 12:

  So to avoid this error, in each file will be needed to assign a value to `$title` variable, before load the view, like:

  ```php

    // index.php

    ....

    $title = 'List of Topics';

    require './views/index.view.php';

  ```

  in `create.php`

  ```php

    // create.php
    ....

    $title = 'New Topic';

    require './views/create.view.php';

  ```

  And:

  ```php

    $title = "Edit Topic - {$topic['title']}";

    require './views/edit.view.php';

  ```

  With this you will see a value of the title on browser tab and in case of create or edit in the page too, where edit will show also the name o current topic.

## Explanation

In this chapter you learn about separate business logic from presentation for better code organization as well as with partils to avoid repetead views.

With this concepts will allow to understand some concepts that frameworks use.
