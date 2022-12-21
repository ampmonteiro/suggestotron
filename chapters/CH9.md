# Chapter 9 - Introducing Views with Layout

## Goals

- Learn about Namespaces
- Learn about layouts
- Alternative Ways to process layout and views

## Steps

- Step 1:

    We are going to create a new class for handling our Views / templates by using an Engine.

    Now that we are adding more classes, let us create a directory especially for them.

    This directory should live in the root of our project, and is called `src`.

- Step 2: 

    Our `ViewEngine` class will live in the `src/Core/ViewEngine.php` file:

    ```php
        <?php

        namespace App\Core;

        class ViewEngine
        {
            protected $layout;
            protected $page;

            public function __construct($layout)
            {
                $this->layout =  "{$layout}.view.php";
            }

            public function render($page, $data = [])
            {
                foreach ($data as $key => $value) {
                    $this->{$key} = $value;
                }

                $this->page = "{$page}.view.php";

                require __DIR__ . '/../../views/layouts/' . $this->layout;
            }

            public function content()
            {
                require __DIR__ . '/../../views/' . $this->page;
            }
        }
    ```

    We are not the first people to create a `ViewEngine` class, to prevent it from conflicting with other peoples code, we use a `namespace` to make it `unique`. In this case, `App`. Also instead of `App` you could use the name of the application like `Suggestron`. But nowadays in frameworks `src` folder is always associate to `App` main namespace as root folder.

    To refer to our `ViewEngine` class, we should now use its full name `\App\Core\ViewEngine`.

    Also you could putted the `ViewEngine` class at root of `src` but for better organization, all classes and functions not related to Business logic is putted in the app in centralized here.


- Step 3:

    Now we should move `TopicData` class into `src`, since it is a  class,
    like `namespace App;`, similar to `ViewEngine` class.

- Step 4: 

    Instead of load `header` and `footer` partials in all pages, we can put into single file all html that is in header and footer partils.

    So for that create a folder call `layouts`, inside of views folder.

    Then create `base.view.php` into `views/layouts` and paste the following code:

    ```php

        <?php
        $title = $this->title;
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $title ?></title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>

        <body class="h-screen bg-gray-100 grid grid-rows-[60px_auto_50px]">

            <header class="py-2 bg-sky-900 flex items-center justify-around">
                <h1 class="font-bold text-xl text-white">
                    <a href="/">
                        Suggestron
                    </a>
                </h1>
                <p class="text-white">
                    <a class="p-3 rounded-md font-bold text-gray-50 bg-blue-600 hover:bg-blue-800" href="/create.php">Create</a>
                </p>
            </header>

            <?php $this->content(); ?>

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

- Step 5:

    We then change the `index.view.php` to this:

    ```php

        <?php $result = $this->result; ?>

        <main class="my-10 grid md:grid-cols-2 lg:grid-cols-3 auto-rows-max gap-3 mx-auto max-w-5xl">
            <?php foreach ($result as $item) : ?>
                <article class="flex flex-col justify-between h-52 max-w-sm gap-3 pt-4 px-12 bg-amber-300 text-black drop-shadow-2xl">
                    <h3>
                        <?= h($item['title']) ?>
                        (ID: <?= $item['id'] ?>)
                    </h3>
                    <p>
                        <?= h($item['description']) ?>
                    </p>

                    <p class="self-end flex gap-5 my-3 ">
                        <a class="p-3 rounded-md font-bold text-gray-50 bg-stone-500 hover:bg-stone-700  " href="/edit.php/?id=<?= $item['id'] ?>"> Edit</a>
                        <a class="p-3 rounded-md font-bold text-gray-50 bg-rose-500 hover:bg-rose-700 " href="/delete.php/?id=<?= $item['id'] ?>"> Delete</a>
                    </p>
                </article>

            <?php endforeach; ?>
        </main>
    ```  

    This means that we dont need any more to require header and footer in separed as partils.

- Step 6:

    Now we can update our index.php to use our ViewEngine:

    ```php

        <?php

        require './src/TopicData.php';
        require './src/Core/ViewEngine.php';

        $topics = new \App\TopicData();

        $result = $topics->getAllTopics();

        function h($val)
        {
            return htmlspecialchars($val);
        }

        $title = 'List of Topics';

        $view = new \App\Core\ViewEngine('base');

        $view->render(
            'index',
            compact('title', 'result')
        );
    ```
    
     - Notice how we pass the `$result` variable into the `$template->render()` function. This allows our view to access the data we want it to. It will be accessible as `$this->result` within the view.
        
    - the `compact` functions is the same as: 
    
    ```php 
        ['title' => $title, 'result' => $result] 
    ```

- Step 7:

    If we check our site right now, you'll likely see that it's still broken!

    This is because the `TopicData` class is now inside the `App` namespace, where the `PDO` class does not live.

    To fix this, we must fully-qualify the `PDO` class in \App\TopicData->connect(), by prefixing it with a `\`:

    ```php

        # in TopicData

        ...
                private function connect()
                {
                    $this->connection = new \PDO(
                        "mysql:host={$this->host};dbname={$this->dbname}",
                        $this->user,
                        $this->pwd
                    );
                }
        ...

    ```

    Additionally, we need to prefix the `\PDO::FETCH_ASSOC` constant passed to `$query->fetch()` in `\App\TopicData->getTopic()`:


        ```php

        # in TopicData

        ...
                public function getTopic($id)
                {
                    $sql = "SELECT * 
                            FROM topics 
                            WHERE id = :id 
                            LIMIT 1";

                    $query = $this->connection->prepare($sql);

                    $query->execute([':id' => $id]);

                    return $query->fetch(\PDO::FETCH_ASSOC);
                }
        ...

    ```


- Step 8:

    Now that our index view is working, lets changes the other pages to take advantage of the layout way.

    For `create` related, we will first change the `create.view.php` view to:

    ```php

        <?php
        $title = $this->title;
        ?>

        <main class="p-10 py-4 my-3 md:mx-auto max-w-xs md:max-w-xl">

            <h2 class="mb-6 text-3xl"><?= $title ?></h2>

            <?php require './views/partials/topic-form.php' ?>
        </main>
    ```

    Then add the ViewEngine to `create.php` file:

    ```php

        <?php
        require './src/TopicData.php';
        require './src/Core/ViewEngine.php';

        if (isset($_POST) && sizeof($_POST) > 0) {

            $data = new \App\TopicData();
            $data->create($_POST);

            header("Location: /");
            exit;
        }

        $title = 'New Topic';

        $view = new \App\Core\ViewEngine('base');
        $view->render(
            "create",
            compact('title')
        );

    ```

- Step 9:

    Now, do the same for `edit.view.php`:

    ```php

        <?php
            $title = $this->title;
            $topic = $this->topic;
            ?>

            <main class="p-10 py-4 my-3 mx-auto max-w-xs md:max-w-xl">

                <h2 class="mb-6 text-3xl"><?= $title ?></h2>

                <?php require './views/partials/topic-form.php' ?>
            </main>
    ```

    Then `edit.php`:

    ```php

        <?php
        require './src/TopicData.php';
        require './src/Core/ViewEngine.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

            $data = new \App\TopicData();
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

        $data = new \App\TopicData();
        $topic = $data->getTopic($_GET['id']);

        // if not found returns false
        if (!$topic) {
            die("Topic not found!");
        }

        $title = "Edit Topic - {$topic['title']}";

        $view = new \App\Core\ViewEngine('base');
        $view->render(
            "edit",
            compact('title', 'topic')
        );
    ```

- Step 10:

    For `delete.php`, as we don't actually have any output, we just need to update the `TopicData` class path.

    ```php

        <?php
        require './src/TopicData.php';

        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("You did not pass in an ID.");
        }

        $data = new \App\TopicData();
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

- Step 11:

    If you notice in each view or even in base layout, we need manually assign the again the data to the correct variable from a ViewEngine.

    For example for `base.view.php` file need a `$title` variable and we was doing this:
    `<?php $title = $this->title;?>`

    And in `index.view.php` in even need the `$result` variable `<?php $result = $this->result; ?>`

    And even worse in our `edit.view.php` needs two variable:      
    ```php 
        <?php
            $title = $this->title;
            $topic = $this->topic;
        ?>
    ```

    So to avoid this and simplify again our views, we need to change the `ViewEngine` class, to be more precise the `render` method.

- Step 12:

    So change the `ViewEngine` class to this:

    ```php

        namespace App\Core;

        class ViewEngine
        {
            protected $layout;
            protected $viewPath = '/../../views/';

            public function __construct($layout)
            {
                $this->layout =  $this->viewPath . "/layouts/{$layout}.view.php";
            }

            public function render($view, $data = [])
            {
                $page = $this->viewPath . "{$view}.view.php";

                foreach ($data as $key => $value) {
                    $$key = $value;
                }

                ob_start();
                require __DIR__ . $page;
                $viewContent = ob_get_clean();

                require __DIR__ .  $this->layout;
            }
        }
    ```

    Things to point out:

    - no `content` method 
    - no `page` property
    - new property: `viewPath`
    - instead of assign as property of ViewEngine `$this->{$key} = $value;` is replace with `$$key = $value;` where the `$$` is called as `PHP Variable Variables` more details [here](https://www.phptutorial.net/php-tutorial/php-variable-variables/, 'Variable variables - phptutorial.net')
    - `ob_start` function, that in simple terms is processing ahead of time the selected view and return as string for `$viewContent`
    where this variable is passed and printed in `base.php` layout.
    More detais of this function [here](https://www.php.net/manual/en/function.ob-start.php, 'ob_start - php docs')
    
    As alternative you could use instead of `$$` with a foreach, replace with:

    ```php
        ...
            public function render($view, $data = [])
            {
                $page = $this->viewPath . "{$view}.view.php";

                //foreach ($data as $key => $value) {
                //    $$key = $value;
                //}
                extract($data);

                ob_start();
                require __DIR__ . $page;
                $viewContent = ob_get_clean();

                require __DIR__ .  $this->layout;
            }
        ...
    ```

    More about extract function [here](https://www.php.net/manual/en/function.extract.php, 'extract - php docs')

    Either way, both soluction will result in the same output and better than first soluction with content method, just choose one.

- Step 13:

    Now no need that variables, let remove from the base as:

    ```php

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $title ?></title>
            <script src="https://cdn.tailwindcss.com"></script>
        </head>

        <body class="h-screen bg-gray-100 grid grid-rows-[60px_auto_50px]">

            <header class="py-2 bg-sky-900 flex items-center justify-around">
                <h1 class="font-bold text-xl text-white">
                    <a href="/">
                        Suggestron
                    </a>
                </h1>
                <p class="text-white">
                    <a class="p-3 rounded-md font-bold text-gray-50 bg-blue-600 hover:bg-blue-800" href="/create.php">Create</a>
                </p>
            </header>

            <?= $viewContent ?>

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

    Point out that only change was, remove assign from top of the document and replace `content` method with `<?= $viewContent ?>`

 - Step 14

    In `index.view.php`, you can remove the following line at the top: 
    `<?php $result = $this->result; ?>`

    In `create.view.php`,  no need:  `<?php $title = $this->title;?>`.

    And in `edit.view.php`, no need: 
    ```php    
        <?php
            $title = $this->title;
            $topic = $this->topic;
        ?>
    ```

- Step 15:

    Anothing that is we should always required a layout.

    So Instead on `___construt` passed a layout make more sense pass a view since it is this all about it.

    In the `ViewEngine` class change to :

    ```php

        namespace App\Core;

        class ViewEngine
        {
            protected $view;
            protected $layout;
            protected $viewPath = '/../../views/';

            public function __construct($view)
            {
                $this->view = $this->viewPath . "{$view}.view.php";
            }

            public function render($data = [], $layout = '')
            {
                $currentLayout =  $this->viewPath . "/layouts/{$layout}.view.php";

                # https://www.phptutorial.net/php-tutorial/php-variable-variables/
                foreach ($data as $key => $value) {
                    $$key = $value;
                }

                // or with https://www.php.net/manual/en/function.extract.php
                # extract($data);

                if (empty($layout)) {
                    require __DIR__ . $this->view;
                    exit;
                }

                ob_start();
                require __DIR__ . $this->view;
                $viewContent = ob_get_clean();

                require __DIR__ .  $currentLayout;
            }
        }
    ```

    So now, on `__construt` receives the view / template / page.

    And in `render` method, the params were changes, which are optional, in case no layout, just load a simple view.

- Step 16: 

    Before change index.php with this new way of ViewEngine, if notice in index.php we are defined a function called `h`, for better organization, create a file called helpers in `src/core/` and copy the function.

    Then in index.php load helpers function like  `require './src/Core/helpers.php';`

    After that then will change the new way of call `ViewEngine`.

    ```php

        require './src/Core/helpers.php';
        require './src/TopicData.php';
        require './src/Core/ViewEngine.php';

        $topics = new \App\TopicData();

        $result = $topics->getAllTopics();

        $title = 'List of Topics';

        $view = new \App\Core\ViewEngine('index');
        $view->render(
            compact('title', 'result'),
            'base'
        );
    ```

    And since we have a helpers file, we can improve even more the way call the ViewEngine.

- Step 17:

    So instead to have insteat in each page the ViewEngine, we could improve it by wrapping it on function into `helpers` file called `render` with following code:

    ```php
        # in src/core/helpers

        function h($val)
        {
            return htmlspecialchars($val);
        }

        function render($view, $data = [], $layout = '')
        {
            require 'ViewEngine.php';

            $view = new \App\Core\ViewEngine($view);
            $view->render(
                $data,
                $layout
            );
        }
    ```

- Step 18:
    
    Also we can create a function responsible for loading a partial.

    In ours context, is useful for loading topic form.

    So in `helpers` file, create  `partial` function:

    ```php

        ....

        function partial($name, $data = [])
        {
            extract($data);

            require __DIR__ . '/../../views/partials/' . $name . '.php';
        }

        ....
    
    ```

    Now change `create.view.php` to:

    ```php

        <main class="p-10 py-4 my-3 md:mx-auto max-w-xs md:max-w-xl">
            <h2 class="mb-6 text-3xl"><?= $title ?></h2>
            <?php partial('topic-form') ?>
        </main>
    ```

    And `edit.view.php` to: 

    ```php

        <main class="p-10 py-4 my-3 mx-auto max-w-xs md:max-w-xl">
            <h2 class="mb-6 text-3xl"><?= $title ?></h2>
            <?php partial('topic-form', compact('topic')) ?>
        </main>
    ```

- Step 19 ( Optional and more advance)

    If more flexibility on call ViewEngine you can do it by using functional way with chaining methods.

    where should change the `ViewEngine` class to:

    ```php

        namespace App\Core;

        class ViewEngine
        {
            protected $view = '';
            protected $layout = '';
            protected $data = [];
            protected $viewPath = '/../../views/';

            public function __construct($view)
            {
                $this->view = $this->viewPath . "{$view}.view.php";
            }

            public function render($data = [], $layout = '')
            {
                if (!empty($layout)) {
                    $this->layout =  $this->viewPath . "/layouts/{$layout}.view.php";
                }

                if (!empty($data)) {
                    $this->data = $data;
                }

                # https://www.phptutorial.net/php-tutorial/php-variable-variables/
                foreach ($this->data  as $key => $value) {
                    $$key = $value;
                }

                // or with https://www.php.net/manual/en/function.extract.php
                # extract($data);

                if (empty($this->layout)) {
                    require __DIR__ . $this->view;
                    exit;
                }

                ob_start();
                require __DIR__ . $this->view;
                $viewContent = ob_get_clean();

                require __DIR__ .  $this->layout;
            }

            public function setLayout($layout)
            {
                $this->layout = $this->viewPath . "/layouts/{$layout}.view.php";

                return $this;
            }

            public function setData($values)
            {
                $this->data = $values;

                return $this;
            }
        }
    ```

    Two new methods were added: `setLayout` and `setData`.

    Then should added new function in `helpers` file like:

    ```php

        ...

        function view($currentView)
        {
            require 'ViewEngine.php';

            return new \App\Core\ViewEngine($currentView);
        }

    ```

    Where this function will be responsible for create an instance of `ViewEngine`.


- Step 20 ( Optional and depend on previous step):

    To let try this new function in `index.php` file, this are the ways you could use:

    ```php
        # first way:
        # similar to render but first indicate the view and then when call the render method
        # you passs the as first arg the data and as second the name of the layout
        view('index')
            ->render(
                compact('title', 'result'),
                'base'
            );

        #second way by chainning
        # here you are taking advantage of setData and setLayout method
        # where for last you call render, all this by
        view('index')
                ->setData(
                    compact('title', 'result'),
                )
                ->setLayout('base')
                ->render();

        # the second way is more flexible in case of you dont have data but you want
        # to indicate a layout, because the render method even if you dont have data
        # you have to pass as empty array and than then layout as second arg.
        
        view('index')
            ->setLayout('base')
            ->render();

        # but in this case since layout depends on title you need pass an array with title
        # you could pass this  way

        view('index')
            ->setLayout('base')
            ->render(compact('title'));
        
    ```
    
## Explanation

By adding a layout with views, we can easily make our sites styles consistent. Additionally, we stop ourselves from repeating the same HTML code everywhere, and can change it in one place and effect all of our pages at once!

Also was presented other ways to improve our ViewEngine class to avoid repetion and that allow clean code.
