# Chapter 6 - Deleting Topics

## Goals

- Be able to delete topics from the database

Now nobody will see your mistakes!

## Steps

- Step 1

  First, we modify our foreach to include a Delete link, pointing to `delete.php`:

  ```php

      ....

      <?php foreach ($result as $item) : ?>

          ....

          <p>
              <a href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a> ||
              <a href="/delete.php/?id=<?= $item['id'] ?>"> Delete</a>
          </p>

      <?php endforeach; ?>
  ```

- Step 2

  Then we create `delete.php`, which will delete the topic, and then redirect back to index.php again

  ```php
          <?php
          require 'TopicData.php';

          $id = $_GET['id'] ?? null;

          if (!$id) {
              die("You did not pass in an ID.");
          }

          $data = new TopicData();
          $topic = $data->getTopic($id);

          // if not found returns false
          if (!$topic) {
              die("Topic not found!");
          }

          if ($data->delete($topic['id'])) {
              header("Location: /index.php");
              exit;
          }

          die("An error occurred");

  ```

- Step 3

  Finally, we add our `TopicData->delete()` method into `TopicData` file:

  ```php

      class TopicData
      {
          .....

              public function delete($id)
              {
                  $query = $this->connection->prepare(
                      " DELETE FROM topics
                          WHERE id = :id
                      "
                  );

                  return $query->execute([
                      ':id' => $id,
                  ]);
              }
          .....
      }

  ```

- step 4:

  Once again, you can check this out in your browser. Try going to `topic list` and deleting the new topic you added earlier:

  `http://localhost/`

### Explanation

By now, you've should have a pretty good handle on how this works.

You're able to create, retrieve, update, and delete rows from the database, this is known as `CRUD`, and is something you will find in almost every application.
