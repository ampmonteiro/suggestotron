# Chapter 4 - Creating new topics

## Goals
- Create a way for users to add their own topics to the database

Now we are adding some interactivity to our site!

## Steps

- Step 1

  Create a new file called `create.php` in root folder (suggestron).

  Then we will add an HTML form:

    ```html

      <h2>New Topic</h2>
      <form action="create.php" method="POST">
          <p>
              <label>
                  Title: <input type="text" name="title">
              </label>
          </p>

          <p>
              <label>
                  Description:
                  <br>
                  <textarea name="description" cols="50" rows="20"></textarea>
              </label>
          </p>

          <button> Add Topic </button>

      </form>
    ```

    You can browse to this file at `http://localhost/create.php`

    When you click on `Add Topic`, the form will be submitted back to the server

    By Adding the following, at the top of the page, will let you see what was sent:

    ```php

      <?php
          print_r($_POST);
      ?>
    ```

    Note: 

    We are using a `POST` action in our `<form>`, therefore the data will be available in the `$_POST` super global.

- Step 2

  Now that we have our data, we can go ahead and save it in our database.

  Add the following, replacing `print_r`, at top of create.php:

  ```php
    <?php
    require 'TopicData.php';

    if (isset($_POST) && sizeof($_POST) > 0) {
        $data = new TopicData();
        $data->add($_POST);
    }
    ?>

  ```

  Submitting the form in your browser will now show this:

    Approximate expected result:

    ```
      Fatal error: Uncaught Error: Call to undefined method TopicData::create() in /var/www/html/create.php:7 Stack trace: #0 {main} thrown in /var/www/html/create.php on line 7
    ```

  Don't worry! This is because we haven't added a `TopicData->create()` method yet. 
  
  We will do that next!

- Step 3

    Going back to our `TopicData` class, add the `create` method:

    ```php

          public function create($data)
          {
              $sql = "INSERT INTO topics (
                                      title,
                                      description
                                  ) 
                      VALUES (
                              :title,
                              :description
                              )";

              $query = $this->connection->prepare($sql);

              $query->execute([
                  ':title'       => $data['title'],
                  ':description' => $data['description']
              ]);
          }

    ```

    Note: **For security**, we are using a `prepared query to ensure our data is escaped securely`  before sending it to our database.

- step 4:

   If you submit your form now, you will see another error:

    ```
      Fatal error: Uncaught Error: Call to a member function prepare() on null in /var/www/html/TopicData.php:46 Stack trace: #0 /var/www/html/create.php(7): TopicData->create(Array) #1 {main} thrown in /var/www/html/TopicData.php on line 46

    ```

    This is because we forgot to call TopicData->connect(). Wouldn't it be nice if we didn't even have to remember this?

    We can do this by using a special method called __construct. This is known as the constructor and is automatically called whenever we create a new instance of the class.

    So do following changes in `TopicData` class:

    ```php
    
      class TopicData
        {
            .....

            public function __construct()
            {
                $this->connect();
            }

            private function connect()
            {
                $this->connection = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname}",
                    $this->user,
                    $this->pwd
                );
            }

            .....
        }
    ```

    Now, whenever we call new TopicData() it will automatically connect to the database.

- step 5:

  if you go to `index.php`  by browsing to `http://localhost`, you will find a error:

  ```
    Fatal error: Uncaught Error: Call to private method TopicData::connect() from global scope in /var/www/html/index.php:7 Stack trace: #0 {main} thrown in /var/www/html/index.php on line 7
  ```

  Because the method was change from public to private and only be called by ` __construct` method.

  So remove the following line in index.php: ` $topics->connect();`

  Now you  can verify and see all topics again by refreshing the page `( F5 )`.

- step 6:
 We can automatically forward our users to the list by using the `header()` method with a `Location: /url`  argument.

  Add the following after the call to `$data->create($_POST)`:

  ```php

    $data = new TopicData();
    $data->create($_POST);

    header("Location: /");
    exit;
  ```

  ### Explanation

Our users can now add their own topics, no SQL knowledge required!

We taking the users input from an HTML form, `$_POST`, and using `INSERT` to add it to our database.