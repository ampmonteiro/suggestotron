# Chapter 3 - Creating A Data Class

## Goals

- Write a class to get our data
- Display the topics on a web page
  - A class is a special piece of code for performing a given task

## Steps

- Step 1

  Create a new file called `TopicData.php` in root folder (suggestron).

  Type the following to create our empty class:

  ```php
  <?php
  class TopicData {
      // CLASS CONTENTS GO HERE
  }

  ```

- Step 2

  Now create / add a connect method and respetive properties:

  ```php

  class TopicData
  {
      protected $connection = null;
      protected $host   = '******'; // localhost or ip address if you are using docker
      protected $dbname = 'suggestron';
      protected $user   = '****'; // if you used docker then put dev or root otherwise
      protected $pwd    = '****'; // password defined on container or on the tool

      public function connect()
      {
          $this->connection = new PDO(
              "mysql:host={$this->host};dbname={$this->dbname}",
              $this->user,
              $this->pwd
          );
      }
  }

  ```

- Step 3

    Next lets make a method to get all topics:

    ```php

    class TopicData
    {
        protected $connection = null;
        protected $host   = '******'; // localhost or ip address if you are using docker
        protected $dbname = 'suggestron';
        protected $user   = '****'; // if you used docker then put dev or root otherwise
        protected $pwd    = '****'; // password defined on container or on the tool

        public function connect()
        {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->pwd
            );
        }

        public function getAllTopics()
        {
            $query = $this->connection->prepare("SELECT * FROM topics");
            $query->execute();

            return $query;
        }
    }
    ```

- step 4:

    Now we can use the `TopicData` class in index.php, to get our topics:

    ```php

    <?php
    require 'TopicData.php';

    $topics = new TopicData();

    $topics->connect();

    $result = $topics->getAllTopics();

    ```

- step 5:

  Now we have our topics lets display them by using a foreach to iterate over them.

  Exist several ways to do this:
  - using string concatenation with `.`

    ```php
      foreach ($result as $item) {
        echo "<h3>" .$item['title']. " (ID: " .$item['id']. ")</h3>";
        echo "<p>";
        echo $item['description'];
        echo "</p>";
      }
    ```

  - using string interpolation:
    ```php
      foreach ($result as $item) {
        echo "
            <h3> {$item['title']} (ID: {$item['id']}) </h3>
            <p>{$item['description']}</p>
        ";
      }
    ```

  - using so call `Heredoc`, details [here](https://andy-carter.com/blog/what-are-php-heredoc-nowdoc):
      ```php
        foreach ($result as $item) {
          echo <<<html
                <h3> 
                    {$item['title']} (ID: {$item['id']}) 
                </h3>
                <p>
                    {$item['description']}
                </p>   
            html;
        }
    ```

- step 6:
  To see what this looks like, refresh the application in your browser!

  ![PHP info](/index-result.png 'index result')