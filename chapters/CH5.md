# Chapter 5 - Editing Topics

## Goals

- better way to write PHP with HTML
- Allow users to edit topics
- Preventing XSS (Cross Site Scripting)

Let users change existing data.

## Steps

- Step 1

  Before add a link for each topic in `index.php`, the way mix PHP with can be improved.

  PHP has an alternative syntax to ouput and struturing things.

  So let change `index.php` file to:

  ```php

      require 'TopicData.php';

      $topics = new TopicData();

      $result = $topics->getAllTopics();

      ?>

      <?php foreach ($result as $item) : ?>
          <h3>
              <?= $item['title'] ?> (ID: <?= $item['id'] ?>)
          </h3>
          <p>
              <?= $item['description'] ?>
          </p>

      <?php endforeach; ?>
  ```

  As you can see, it is more clear and easy to work and mix PHP with HTML, where:

  - to output use `<?= 'say something'?> ` equal to `<?php echo 'say something'?>`, the `;` is optional
  - to use / start foreach or other control flow (like if, while, etc) just replace open `{` with `:`
  - to close / end foreach or other control flow just replace `}` with for example `endforeach` (to foreach), `endif` ( if ), etc.

- Step 2

  Now let us add an edit link for each Topic.

  In `index.php` change our foreach to include the link:

  ```php
      <?php foreach ($result as $item) : ?>
          <h3>
              <?= $item['title'] ?>
              (ID: <?= $item['id'] ?>)
          </h3>
          <p>
              <?= $item['description'] ?>
          </p>

          <p>
              <a href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a>
          </p>

      <?php endforeach; ?>
  ```

  The link has been added at the end of our foreach. The link has an argument for the id.

  Note:

  - URL arguments are known as `GET` arguments.
  - They are added to the URL after a `?` and can be found in the `$_GET` superglobal array (just like `$_POST`).
  - Multiple arguments are separated by an `&`.

- Step 3

  Next create another new page, `edit.php`, and add an edit form. This will look almost identical to your new topic form:

  ```html
  <h2>Edit Topic</h2>
  <form action="edit.php" method="POST">
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
        <textarea name="description" cols="50" rows="20">
                      <?= $topic['description'] ?>
                  </textarea
        >
      </label>
    </p>

    <input type="hidden" name="id" value="<?= $topic['id']; ?>" />

    <button>Edit Topic</button>
  </form>
  ```

  We use echo tags `<?=$variable;?>`, short syntax again, to output the current values into the form, and a hidden input to submit the topics ID back to the server, so we know which one we are editing.

- step 4:

  Then we need to fetch the requested topic, so that we can fill in the data.

  We do this, by adding a `getTopic()` method to our `TopicData` class.

  ```php

    class TopicData
      {
          .....

          public function getTopic($id)
          {
              $sql = "SELECT * FROM topics WHERE id = :id LIMIT 1";
              $query = $this->connection->prepare($sql);

              $query->execute([':id' => $id]);

              return $query->fetch(PDO::FETCH_ASSOC);
          }
          .....
      }
  ```

  Here, we introduce a LIMIT 1 to ensure only one row is returned. We then use $query->fetch(PDO::FETCH_ASSOC) to return just the single row as an array.

- step 5:

  Now that you have a way to get the topic, we can use it in `edit.php` by adding the following at the top:

  ```php
      <?php
          require 'TopicData.php';

          $data = new TopicData();
          $topic = $data->getTopic($_GET['id']);
      ?>

  ```

  if you verify the `$topic` value, with `var_dump` function, you will see something lile:

  ![edit topic](row_topic.png 'var_dump topic')

  At this point, you should be able to see your topic data in the edit form, but if you submit the form nothing will change (yet).

- step 6:

  We don't yet have any error checking in case a user tries to visit a link with a bad ID, or without an ID. Go ahead and play with the URL to see what happens!

  Here are some example URLs:

  - No ID: `localhost/edit.php`
  - Invalid ID: `localhost/edit.php?id=1337`

- step 7:

  We can handle this by adding some extra checks in to your code:

  ```php

      require 'TopicData.php';

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

  ```

  we get id from `$_GET` super global and with `??` ( Null Coalescing Operator, since php 7) instead of `isset`, initialize the id variable with a value or null in case not existing in the query params the key id or with no value.

  We also check, to make sure that we did not get a false response from TopicData->getTopic() which would mean that no topic was found

- step 7:

  Now that we have our form, we can go ahead and update the row in the database. First, lets add an TopicData->update() method

  ```php

    class TopicData
      {
          .....

          public function update($data)
          {
              $query = $this->connection->prepare(
                  "UPDATE topics
                  SET
                      title = :title,
                      description = :description
                  WHERE
                      id = :id"
              );

              $data = [
                  ':id'          => $data['id'],
                  ':title'       => $data['title'],
                  ':description' => $data['description']
              ];

              return $query->execute($data);
          }

          .....
      }
  ```

- step 8:

  Finally, like with adding topics, we need to call it in `edit.php` by adding the following under the require `'TopicData.php';`:

  ```php
      ....

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

          $data = new TopicData();
          if ($data->update($_POST)) {
              header("Location: /index.php");
              exit;
          }

          die("An error occurred");
      }
      ....

  ```

  Instead of doing something similiar to create, instead verify if `$_POST` super global is empty.

  We can verify which method was executed and then it has `id` in `$_POST` super global.

  In case update fail show error otherwise redirect to `index.php` page

- step 9:

  Now we can create and edit topics, but with a big problem in terms of security.

  You should never trust in the data / input that user send to database.

  You should always escape untrusted input to avoid `XSS` problems, for example in `index.php` page

  An example of `xss attack`, would be if you use put html tag like script others html tags in title or description inputs , which could way your showing the list of topics or worst with js script.

- step 10:

  So how can we prevent `xss attack` in PHP?

  In index.php before echo value of topic, call htmlspecialchars function, which will escape and prevent the attack, see:

  ```php

      <?php foreach ($result as $item) : ?>
          <h3>
              <?= htmlspecialchars($item['title']) ?>
              (ID: <?= $item['id'] ?>)
          </h3>
          <p>
              <?= htmlspecialchars($item['description']) ?>
          </p>

          <p>
              <a href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a>
          </p>

      <?php endforeach; ?>

  ```

  The function is applied only on fields that user can changed, like `title` and `description`

- step 10:

  to improve a custom function can be created a call, like this:

  ```php
      ....

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

  ```

  ### Explanation

  Similar to when our users created topics, we take our users input, $\_POST, but this time we perform an UPDATE SQL command.

  Also, we've started to add some input validation as well as escape data to avoid `XSS attack`, which is critical for security!
