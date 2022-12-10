<?php

require 'TopicData.php';

$topics = new TopicData();

$topics->connect();

$result = $topics->getAllTopics();

$topics->connect();

foreach ($result as $item) {

    // echo "
    //     <h3> {$item['title']} (ID: {$item['id']}) </h3>
    //     <p>{$item['description']}</p>
    // "; or
    // with heredoc: https://andy-carter.com/blog/what-are-php-heredoc-nowdoc

    echo <<<html
            <h3> 
                {$item['title']} (ID: {$item['id']}) 
            </h3>
            <p>
                {$item['description']}
            </p>   
        html;
}
